<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $referralCode = $request->query('ref');
        return view('auth.register', compact('referralCode'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'regex:/^\d{10}$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:4'],
            'source' => ['string', 'max:255'],
        ]);

        if ($request->filled('referral_code')) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $referredBy = $referrer->referral_code;
                if ($referrer->hasRole('ADMIN') || $referrer->hasRole('PARTNER')) {                    
                    $createdBy = $referrer->id;
                } else {
                    $createdBy = $referrer->created_by;
                }                
            }
        } else{
            $user_admin = User::find(1);
            $referredBy = $user_admin->referral_code;
            $createdBy = $user_admin->id;
        }

        $referalCode = strtoupper(Str::random(20));

        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'referral_code' => $referalCode,
            'referred_by' => $referredBy,
            'created_by' => $createdBy
        ]);

        if($request->source ==='admin'){
            $user_find = User::find($user->id);
            $user_find->assignRole('ADMIN');
        }
        else{
            $user_find = User::find($user->id);
            $user_find->assignRole('CUSTOMER');
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->hasRole('ADMIN')) {
            return redirect(route('dashboard', absolute: false));
        } elseif ($user->hasRole('PARTNER')) {
            return redirect()->route('partnerdashboard');
        } else {
            return redirect(route('home', absolute: false));
        }

        // return redirect(route('dashboard', absolute: false));
    }
}
