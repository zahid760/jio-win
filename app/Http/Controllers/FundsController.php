<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\AccountDetail;
use App\Models\PaymentRequest;
use App\Models\UserBankDetails;
use App\Models\GameRate;
use App\Models\WithdrawRequests;
use App\Models\User;
use App\Models\Support;
use App\Models\Notification;
use Auth;

class FundsController extends Controller
{
    protected $wallet;
    protected $deposite_wallet;
    protected $bonus_wallet;
    protected $winning_wallet;

    public function __construct() {
        $this->wallet = Auth::user()->deposite_wallet + Auth::user()->bonus_wallet + Auth::user()->winning_wallet;
        $this->deposite_wallet = Auth::user()->deposite_wallet;
        $this->bonus_wallet = Auth::user()->bonus_wallet;
        $this->winning_wallet = Auth::user()->winning_wallet;
    }

    public function funds()
    {
        return view('customer.funds');
    }

    public function add_fund()
    {
        $wallet = number_format($this->wallet, 2);
        $deposite_wallet = $this->deposite_wallet;
        $bonus_wallet = $this->bonus_wallet;
        $winning_wallet = $this->winning_wallet;
        $support = Support::where('created_by', Auth::user()->created_by)->get()->first();
        return view('customer.add_fund', compact('wallet', 'deposite_wallet', 'bonus_wallet', 'winning_wallet', 'support'));
    }
    
    public function add_cash()
    {
        $created_by  = Auth::user()->created_by;
        $account_details = AccountDetail::where('created_by', $created_by)->get()->first();
        $wallet = number_format($this->wallet, 2);
        return view('customer.add_cash', compact('account_details', 'wallet'));
    }

    public function payment_request_store(Request $request)
    {
        try{
            $request->validate([
                'transaction_id' => ['required', 'string', 'unique:payment_requests'],
                'amount' => ['required', 'numeric'],
                'comment' => ['nullable', 'string'],
                'screenshot' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp'],
            ]);

            if($request->hasFile('screenshot')) {
                $directory = 'assets/payment_reciept'; // Define the folder inside 'public'
                
                if (!File::exists(public_path($directory))) {
                    File::makeDirectory(public_path($directory), 0777, true, true);
                }
                $type = $request->file('screenshot')->getClientOriginalExtension();
                $imageName = 'receipt_'. time() . '_' . uniqid() . '.' . $type;
                $request->file('screenshot')->move(public_path($directory), $imageName);
                $request->merge(['reciept_photo' => $directory . '/' . $imageName]);
            }
            
            $request->merge(['created_by' => Auth::id()]);
            $notificationData = [
                'title'         => 'Payment Request',
                'description'   => 'Payment request created by '.Auth::user()->name,
                'user_id'       => Auth::id(),
                'winer_user_id' => Auth::id(),
                'event_type'    => '1', // 1 for user Payment Request notification
            ];
            $data = $request->all();
            $notification = Notification::create($notificationData);
            $payment_request = PaymentRequest::create($data);
            
            if($payment_request && $notification){
                return response()->json(['status'=>'success',  'message' => 'Thank you for deposit your amount will credit within 45 minutes.'], 200);
            }
            
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function fund_history()
    {
        $payment_request = PaymentRequest::where('created_by', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('customer.fund_history', compact('payment_request'));
    }

    public function bank_detail()
    {
        $bank_detail = UserBankDetails::where('created_by', Auth::user()->id)->get()->first();
        return view('customer.bank_detail', compact('bank_detail'));
    }

    public function bank_detail_store(Request $request)
    {
        try{
            $request->validate([
                'name' => ['required', 'string'],
                'account_number' => ['required', 'string'],
                'ifsc' => ['required', 'string'],
                'bank_name' => ['required', 'string'],
                'upi_id' => ['nullable', 'string'],
            ]);

            $id = $request->id;
            if(empty($id)){
                $request->merge(['created_by' => Auth::id()]);
                $data = $request->all();   
                $bank_detail = UserBankDetails::create($data);
            }else{
                $request->merge(['updated_by' => Auth::id()]);
                $data = $request->all();   
                $bank_detail = UserBankDetails::find($id);
                $bank_detail->update($data);
            }

            if($bank_detail){
                return response()->json(['status'=>'success',  'message' => 'Bank details updated successfully.'], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function game_rate()
    {
        $game_rate = GameRate::where('created_by', Auth::user()->created_by)->get();
        return view('customer.game_rate', compact('game_rate'));
    }

    public function withdraw_fund()
    {
        return view('customer.withdraw_fund');
    }

    public function withdraw_fund_store(Request $request)
    {
        try{
            $bank_detail = UserBankDetails::where('created_by', Auth::user()->id)->first();

            if (!$bank_detail) {
                return response()->json(['status' => 'error', 'message' => 'Bank details are required to proceed.'], 400);
            }

            $request->validate([
                'amount' => ['required', 'numeric',
                    function ($attribute, $value, $fail) {
                        if ($value > Auth::user()->winning_wallet) {
                            $fail("The $attribute must not be greater than your winning wallet balance.");
                        }
                    },
                ],
            ]);

            $request->merge(['created_by' => Auth::id()]);
            $notificationData = [
                'title'         => 'Payment withdraw Request',
                'description'   => 'Payment request created by '.Auth::user()->name,
                'user_id'       => Auth::id(),
                'winer_user_id' => Auth::id(),
                'event_type'    => '2', // 1 for user Payment withdraw Request notification
            ];
            $data = $request->all();
            $notification = Notification::create($notificationData);
            $withdraw_request = WithdrawRequests::create($data);

            if($withdraw_request && $notification){
                $user = User::find(Auth::id());
                $wining = ($user->winning_wallet - $request->amount);
                $wallet = ($user->wallet - $request->amount);
                $user->update(['wallet'=>$wallet, 'winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                if($user){
                    return response()->json(['status'=>'success',  'message' => 'Withdraw request created successfully.'], 200);
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function withdraw_fund_history()
    {
        $withdraw_request = WithdrawRequests::where('created_by', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('customer.withdraw_fund_history', compact('withdraw_request'));
    }
}
