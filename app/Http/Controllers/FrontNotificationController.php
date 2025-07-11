<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;

class FrontNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // where('event_type', '0')->where('user_id', Auth::id())->where('winer_user_id', Auth::id())->
        $notificcations = Notification::where(function($query) {
            $userId = Auth::id();
            $query->where('user_id', $userId)
            ->orWhere('winer_user_id', $userId)
            ->orWhereNull('user_id')
            ->orWhereNull('winer_user_id');
        })
        ->orderBy('id', 'DESC')
        ->get();
        // dd($notificcations);
        return view('customer.notification', compact('notificcations'));
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

    public function show_notification($id)
    {
        $Getnotification = Notification::find($id);
        // Mark the notification as read
        return view('customer.show_notification', compact('Getnotification'));
        
    }
}
