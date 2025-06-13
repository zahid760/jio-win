<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PaymentRequest;
use App\Models\Bids;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->hasRole('ADMIN')){
            $data = User::role('CUSTOMER')->where('id', '!=', 1)->orderBy('id', 'DESC')->get();
        }else{
            $data = User::role('CUSTOMER')->where('created_by', Auth::id())->orderBy('id', 'DESC')->get();
        }
        return view('admin.user.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'mobile' => ['required', 'regex:/^\d{10}$/', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $referalCode = strtoupper(Str::random(20));

            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'referral_code' => $referalCode,
                'referred_by' => Auth::user()->referral_code,
                'created_by' => Auth::id(),
            ]);

            $user_find = User::find($user->id);
            $user_find->assignRole('CUSTOMER');           

            return response()->json(['status'=>'success',  'message' => 'User created successfully.'], 200);
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::find($id);
        return view('admin.user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'mobile' => ['required', 'regex:/^\d{10}$/', 'unique:users,mobile,'.$id],
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::find($id);
            $data = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'updated_by' => Auth::id(),
            ];
            if(!empty($request->password)){
                $data['password'] = Hash::make($request->password);
            }
            $user->update($data);

            if($user){
                return response()->json(['status'=>'success',  'message' => 'User updated successfully.'], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status'=>'failed', 'message'=>'User not found.']);
        }else{
            $user->delete();
            return response()->json(['status'=>'success', 'message'=>'User deleted successfully.']);
        }
    }

    public function user_manual_payment(Request $request)
    {
        try{
            $request->validate([
                'transaction_id' => ['required', 'string', 'max:255', 'unique:payment_requests,transaction_id'],
                'amount' => ['required', 'numeric'],
            ]);

            $userid = $request->userid;
            $amount = $request->amount;
            $payment = PaymentRequest::create([
                'transaction_id' => $request->transaction_id,
                'amount' => $amount,
                'status' => 1,
                'created_by' => $userid,
                'updated_by' => Auth::id(),
            ]);

            if($payment){
                $user_find = User::find($userid);
                $deposite_wallet = $user_find->deposite_wallet + $amount;
                $user_find->update(['deposite_wallet'=>$deposite_wallet]);
                return response()->json(['status'=>'success',  'message' => 'Transaction created successfully.'], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function user_history($id)
    {
        $matka_bids = Bids::with('game', 'gamemode', 'bidchild')->where(['category'=>'matka', 'created_by'=>$id])->orderBy('id', 'DESC')->get();
        $satta_bids = Bids::with('game', 'gamemode', 'bidchild')->where(['category'=>'satta', 'created_by'=>$id])->orderBy('id', 'DESC')->get();
        
        return view('admin.user.history', compact('matka_bids', 'satta_bids'));
    }
}
