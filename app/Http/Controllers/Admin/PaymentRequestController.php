<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Models\WithdrawRequests;
use Auth;

class PaymentRequestController extends Controller
{
    public function payment_request_list()
    {
        $data = PaymentRequest::whereHas('user', function ($query) {
            $query->where('created_by', Auth::id());
        })->orderBy('id', 'DESC')->get();
        
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
                $user = User::find($userid);
                $deposite = ($user->deposite_wallet + $amount);
                $wallet = ($user->wallet + $amount);
                $user->update(['wallet'=>$wallet, 'deposite_wallet'=>$deposite, 'updated_by'=>Auth::id()]);
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
