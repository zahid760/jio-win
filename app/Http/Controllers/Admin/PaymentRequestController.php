<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Models\WithdrawRequests;
use App\Models\Bonus;
use Auth;

class PaymentRequestController extends Controller
{
    public function payment_request_list()
    {
        $data = PaymentRequest::whereHas('user', function ($query) {
            $query->where('created_by', Auth::id());
        })->where('status', '!=', 3)->orderBy('id', 'DESC')->get();
        
        return view('admin.payment_request_list', compact('data'));
    }

    public function payment_status(Request $request)
    {
        try{
            $request->validate([
                'id' => ['required', 'integer'],
                'status' => ['required', 'integer'],
            ]);

            $id = $request->id;
            $payment_request = PaymentRequest::find($id);
            if($request->status == 1){
                $amount = $payment_request->amount;
                $userid = $payment_request->created_by;
                $checkPaymentRequests = PaymentRequest::where('created_by', $userid)->count();
                $user = User::find($userid);
                $bonus = Bonus::where('created_by', $user->created_by)->first();
                $bonus_amt = 0;
                if($checkPaymentRequests == 1)
                {
                    $bonus_amt += $bonus->amount;
                }
                $percent = $bonus->percent;
                $total_percent_amount = ($amount * $percent) / 100;

                $total_bonus_amt = ($bonus_amt + $total_percent_amount);
                $total_bonus = ($user->bonus_wallet + $total_bonus_amt);
                $total_deposite = ($user->deposite_wallet + $amount);
                $user->update(['deposite_wallet'=> $total_deposite, 'bonus_wallet'=> $total_bonus, 'updated_by'=>Auth::id()]);

                $referUser = User::where('referral_code', $user->referred_by)->get()->first();
                $referUser_bonus_amt = ($referUser->bonus_wallet + $total_percent_amount);
                $referUser->update(['bonus_wallet'=> $referUser_bonus_amt, 'updated_by'=>Auth::id()]);
                
                PaymentRequest::create([
                    'amount' => $total_bonus_amt,
                    'status' => 3,
                    'created_by' => $user->id,
                ]);

                PaymentRequest::create([
                    'amount' => $total_percent_amount,
                    'status' => 3,
                    'created_by' => $referUser->id,
                ]);
            }
            
            $data = [
                'status'=>$request->status,
                'updated_by'=>Auth::id()
            ];
            
            $payment_request->update($data);

            if($payment_request){
                return response()->json(['status'=>'success',  'message' => 'Payment request updated successfully.'], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function withdraw_request_list()
    {
        $data = WithdrawRequests::whereHas('user', function ($query) {
            $query->where('created_by', Auth::id());
        })->orderBy('id', 'DESC')->get();
        
        return view('admin.withdraw_request_list', compact('data'));
    }

    public function withdraw_status(Request $request)
    {
        try{
            $request->validate([
                'id' => ['required', 'integer'],
                'status' => ['required', 'integer'],
                'transaction_id' => ['nullable', 'string'],
            ]);

            $id = $request->id;
            $withdraw_request = WithdrawRequests::find($id);
            if($request->status == 2){
                $amount = $withdraw_request->amount;
                $userid = $withdraw_request->created_by;
                $user = User::find($userid);
                $winning = ($user->winning_wallet + $amount);
                $wallet = ($user->wallet + $amount);
                $user->update(['wallet'=>$wallet, 'winning_wallet'=>$winning, 'updated_by'=>Auth::id()]);

                $data = [
                    'status'=>$request->status,
                    'updated_by'=>Auth::id()
                ];
            }
            else{
                $data = [
                    'status'=>$request->status,
                    'transaction_id'=>$request->transaction_id,
                    'updated_by'=>Auth::id()
                ];
            }
            
            $withdraw_request->update($data);

            if($withdraw_request){
                return response()->json(['status'=>'success',  'message' => 'Withdraw request updated successfully.'], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }
}
