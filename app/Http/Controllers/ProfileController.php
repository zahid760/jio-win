<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    // change password
    public function changePassword(Request $request)
    {
        return view('customer.change_password');
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user = Auth::user();

            // Check if current password matches
            if (!\Hash::check($request->current_password, $user->password)) {
                return response()->json(['status'=>'false',  'message' => 'Current password is incorrect.'], 400);
            }
            
            // Check if new password and confirmation match
            if ($request->new_password !== $request->new_password_confirmation) {
                return response()->json(['status'=>'false',  'message' => 'New password and confirmation do not match.'], 400);
            }

            // Update password
            $user->password = bcrypt($request->new_password);
            $user->save();

            return response()->json(['status'=>'success', 'message' => 'Password updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status'=>'false', 'message' => $e->getMessage()], 500);
        }
    }
}
