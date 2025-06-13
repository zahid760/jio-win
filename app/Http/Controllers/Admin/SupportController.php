<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Support;
use Auth;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Support::where('created_by', Auth::id())->get()->first();

        return view('admin.setting.support', compact('data'));
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
                'whatsapp_no' => ['required', 'string'],
                'call_no' => ['nullable', 'string'],
            ]);

            $id = $request->id;
            if(empty($id)){
                $request->merge(['created_by' => Auth::id()]);
                $data = $request->all();                
                $support = Support::create($data);

                if($support){
                    return response()->json(['status'=>'success',  'message' => 'Support saved successfully.'], 200);
                }
            }
            else{
                $request->merge(['updated_by' => Auth::id()]);
                $data = $request->all();
                $support = Support::find($id);
                $support->update($data);

                if($support){
                    return response()->json(['status'=>'success',  'message' => 'Support saved successfully.'], 200);
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
