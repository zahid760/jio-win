<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user(); // Get the authenticated user

        if ($user->hasRole('ADMIN')) {
            return redirect()->intended(route('dashboard', absolute: false));
        } elseif ($user->hasRole('PARTNER')) {
            // Check if the end_date is expired
            if ($user->end_date && $user->end_date < now()) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'end_date' => 'Your partnership period has expired.',
                ]);
            }
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('home');
        }

        // return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
