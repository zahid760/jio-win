<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Auth;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::role('PARTNER')->orderBy('id', 'DESC')->get();
        return view('admin.partner.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partner.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'mobile' => ['required', 'regex:/^\d{10}$/', 'unique:users,mobile'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                'amount' => ['required', 'integer', 'min:0'],
                'game_permissions' => ['nullable', 'array'],
                'game_permissions.*' => ['string', 'exists:permissions,name'],
            ]);

            DB::beginTransaction();

            $referalCode = strtoupper(Str::random(20));

            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'parent' => Auth::id(),
                'password' => Hash::make($request->password),
                'referral_code' => $referalCode,
                'referred_by' => Auth::user()->referral_code, // fixed
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'amount' => $request->amount,
                'created_by' => Auth::id(),
            ]);

            $user->assignRole('PARTNER');

            $permissions = $request->input('game_permissions', []);
            $user->syncPermissions($permissions);

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Partner created successfully.'], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(), // fixed: correct method to get validation errors
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
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
        return view('admin.partner.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'mobile' => ['required', 'regex:/^\d{10}$/', 'unique:users,mobile,' . $id],
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                'amount' => ['required', 'numeric', 'min:0'],
                'game_permissions' => ['nullable', 'array'],
                'game_permissions.*' => ['string', 'exists:permissions,name'],
            ]);

            $user = User::find($id);

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
            }

            DB::transaction(function () use ($request, $user) {
                $data = [
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'amount' => $request->amount,
                    'updated_by' => Auth::id(),
                ];

                if (!empty($request->password)) {
                    $data['password'] = Hash::make($request->password);
                }

                $user->update($data);

                $permissions = $request->input('game_permissions', []);
                $user->syncPermissions($permissions);      
            });

            return response()->json(['status' => 'success', 'message' => 'Partner updated successfully.'], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status'=>'failed', 'message'=>'Partner not found.']);
        }else{
            $user->delete();
            return response()->json(['status'=>'success', 'message'=>'Partner deleted successfully.']);
        }
    }

    public function user_transfer(Request $request)
    {
        $request->validate([
            'partner_from' => ['required', 'integer', 'different:partner_to'],
            'partner_to' => ['required', 'integer'],
        ], [
            'partner_from.different' => 'The source and destination partners must be different.',
        ]);

        $partnerToUser = User::find($request->partner_to);
        if (!$partnerToUser) {
            return response()->json([
                'status' => 'error',
                'message' => 'Partner To user not found.'
            ], 404);
        }
        $referred_by = $partnerToUser->referral_code;

        // Update the users where created_by is partner_from, setting created_by to partner_to
        $affected = User::where('created_by', $request->partner_from)
            ->update(['referred_by' => $referred_by, 'created_by' => $request->partner_to]);

        return response()->json([
            'status' => 'success',
            'message' => "$affected users transferred successfully."
        ]);        
    }
}
