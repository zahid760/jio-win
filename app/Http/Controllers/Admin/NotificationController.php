<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Notification::get();
        return view('admin.notification.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notification.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
            ]);

            $data = Notification::create([
                'title' => $request->title,
                'description' => $request->description,
                'created_by' => Auth::id(),
            ]);           

            return response()->json(['status'=>'success',  'message' => 'Notification created successfully.'], 200);
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
        $data = Notification::find($id);
        return view('admin.notification.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
            ]);

            $notification = Notification::find($id);
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'updated_by' => Auth::id(),
            ];
            $notification->update($data);

            return response()->json(['status'=>'success',  'message' => 'Notification updated successfully.'], 200);
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
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['status'=>'failed', 'message'=>'Notification not found.']);
        }else{
            $notification->delete();
            return response()->json(['status'=>'success', 'message'=>'Notification deleted successfully.']);
        }
    }
}
