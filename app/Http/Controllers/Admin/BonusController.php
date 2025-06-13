<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bonus;
use Auth;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Bonus::where('created_by', Auth::id())->get()->first();
        return view('admin.setting.bonus', compact('data'));
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
        try{
            $request->validate([
                'amount' => ['required', 'numeric'],
                'percent' => ['required', 'numeric'],
            ]);

            $id = $request->id;
            if(empty($id)){
                $request->merge(['created_by' => Auth::id()]);
                $data = $request->all();                
                $bonus = Bonus::create($data);

                if($bonus){
                    return response()->json(['status'=>'success',  'message' => 'Bonus saved successfully.'], 200);
                }
            }
            else{
                $request->merge(['updated_by' => Auth::id()]);
                $data = $request->all();
                $bonus = Bonus::find($id);
                $bonus->update($data);

                if($bonus){
                    return response()->json(['status'=>'success',  'message' => 'Bonus saved successfully.'], 200);
                }
            }
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
