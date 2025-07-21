<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationsSetting;
use Auth;

class FrontNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // where('event_type', '0')->where('user_id', Auth::id())->where('winer_user_id', Auth::id())->
        $userId = Auth::id();
        $checkSettings = NotificationsSetting::where('user_id', $userId)->first();
        $Getnotification = collect(); // Start as empty Laravel collection

        // Add custom event_type = 5 notifications if matka or satta is enabled
        if(!empty($checkSettings) && $checkSettings->matka_game == 1)
        {
            $customNotification = Notification::where('event_type', 5)->where('title', 'matka game result out')->get();
            $Getnotification = $Getnotification->merge($customNotification); // merge safely with collection
        }
        if(!empty($checkSettings) &&  $checkSettings->satta_game == 1)
        {
            $customNotification = Notification::where('event_type', 5)->where('title', 'Satta game result out')->get();
            $Getnotification = $Getnotification->merge($customNotification);
        }

        // Get all user-related notifications
        $generalNotifications = Notification::where('event_type', 0)->get();
        $relatedNotifications = Notification::whereIn('event_type', [1, 2, 3, 4])
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)->orWhere('winer_user_id', $userId);
            })->get();

        // Merge both collections
        $notificcations = $Getnotification->merge($generalNotifications)->merge($relatedNotifications)->sortByDesc('id')->values();

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
        try {
            $userId = Auth::id();
            $settings = NotificationsSetting::firstOrNew(['user_id' => $userId]);

            $settings->matka_game = $request->input('matka_game') === 'on' ? 1 : 0;
            $settings->satta_game = $request->input('satta_game') === 'on' ? 1 : 0;
            $settings->updated_by = $userId;

            if (!$settings->exists) {
                $settings->created_by = $userId;
            }
            $settings->save();

            return response()->json(['status' => 'success', 'message' => 'Notification settings updated successfully.'], 200);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message' => $failures]);
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

    public function notification_settings()
    {
        $settings = NotificationsSetting::where('user_id', Auth::id())->first();
        return view('customer.notification_settings', compact('settings'));
    }

    public function update_notification_settings(Request $request)
    {
        $request->validate([
            'matka_game' => 'boolean',
            'satta_game' => 'boolean',
        ]);

        $settings = NotificationsSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'matka_game' => $request->input('matka_game', false),
                'satta_game' => $request->input('satta_game', false),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]
        );

        return redirect()->back()->with('success', 'Notification settings updated successfully.');
    }
}
