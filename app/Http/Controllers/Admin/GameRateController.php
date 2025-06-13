<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameRate;
use App\Models\GameMode;
use Auth;

class GameRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = GameRate::where('created_by', Auth::id())->orderBy('id', 'DESC')->get();
        return view('admin.setting.game_rate.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $game_mode = GameMode::orderBy('ordering', 'ASC')->get();
        return view('admin.setting.game_rate.add', compact('game_mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'category' => ['required', 'string', 'max:255',],
                'gamemode' => ['required', 'integer'],
                'bidding_rate' => ['required', 'numeric'],
                'winning_rate' => ['required', 'numeric'],
            ]);
            
            $rate = ($request->winning_rate / $request->bidding_rate) ;
            $request->merge(['rate' => $rate]);
            $request->merge(['created_by' => Auth::id()]);
            $data = $request->all();            
            $gamerate = GameRate::create($data);

            if($gamerate){
                return response()->json(['status'=>'success',  'message' => 'Game rate created successfully.'], 200);
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
        $data = GameRate::find($id);
        $game_mode = GameMode::orderBy('ordering', 'ASC')->get();
        return view('admin.setting.game_rate.edit', compact('data', 'game_mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                'category' => ['required', 'string', 'max:255',],
                'gamemode' => ['required', 'integer'],
                'bidding_rate' => ['required', 'numeric'],
                'winning_rate' => ['required', 'numeric'],
            ]);

            $rate = ($request->winning_rate / $request->bidding_rate) ;
            $request->merge(['rate' => $rate]);
            $request->merge(['updated_by' => Auth::id()]);
            $data = $request->all();            
            $gamerate = GameRate::find($id);
            $gamerate->update($data);

            if($gamerate){
                return response()->json(['status'=>'success',  'message' => 'Game rate updated successfully.'], 200);
            }
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
        $gamerate = GameRate::find($id);

        if (!$gamerate) {
            return response()->json(['status'=>'failed', 'message'=>'Game rate not found.']);
        }else{
            $gamerate->delete();
            return response()->json(['status'=>'success', 'message'=>'Game rate deleted successfully.']);
        }
    }
}
