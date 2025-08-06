<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\PaymentRequest;
use App\Models\WithdrawRequests;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalUserCount = [];
        $totalPartnerCount = [];
        $totalPaymentAmount = [];
        $totalWithdrawAmount = [];
        if(Auth::user()->hasRole('ADMIN'))
        {
            $users = User::role('CUSTOMER')->where('id', '!=', 1)->orderBy('id', 'DESC')->get();
            $partners = User::role('PARTNER')->where('id', '!=', 1)->orderBy('id', 'DESC')->get();
            $PaymentRequest = PaymentRequest::where('status', '!=', 2)->orderBy('id', 'DESC')->get();
            $WithdrawRequests = WithdrawRequests::where('status', '!=', 2)->orderBy('id', 'DESC')->get();
            $ids =  $users->pluck('id')->toArray();
            $totalUserCount = $users->count();
            $totalPartnerCount = $partners->count();
            $totalPaymentAmount = round($PaymentRequest->sum('amount'));
            $totalWithdrawAmount = round($WithdrawRequests->sum('amount'));
        }
        elseif(Auth::user()->hasRole('PARTNER'))
        {
            $users = User::role('CUSTOMER')->where('created_by', Auth::id())->orderBy('id', 'DESC')->get();
            $ids =  $users->pluck('id')->toArray();
            $PaymentRequest = PaymentRequest::whereIn('created_by', $ids)->where('status', '!=', 2)->orderBy('id', 'DESC')->get();
            $WithdrawRequests = WithdrawRequests::whereIn('created_by', $ids)->where('status', '!=', 2)->orderBy('id', 'DESC')->get();

            $totalUserCount = $users->count();
            $totalPaymentAmount = round($PaymentRequest->sum('amount'));
            $totalWithdrawAmount = round($WithdrawRequests->sum('amount'));
        }
        $referCode = Auth::user()->referral_code;
        return view('admin.dashboard', compact('referCode', 'totalUserCount', 'totalPartnerCount', 'totalPaymentAmount', 'totalWithdrawAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
