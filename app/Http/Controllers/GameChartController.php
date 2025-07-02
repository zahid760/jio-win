<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameMaster;
use App\Models\Bids;
use App\Models\GameResult;
use \Carbon\Carbon;
use App\Models\User;
use Auth;

class GameChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customer.game_chart');
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

    public function matka_panel_chart()
    {
        $user = User::find(Auth::id());
        $creator = User::find($user->created_by);
        $games = [];
        if($creator->hasRole('PARTNER'))
        {
            $admin_ids = User::role('ADMIN')->pluck('id')->toArray();
            $games = GameMaster::where('category', 'matka')->whereIn('created_by', array_merge([$creator->id], $admin_ids))->orderBy('open_time', 'ASC')->get();
            // dd(array_merge([$creator->id], $admin_ids));
        }
        elseif($creator->hasRole('ADMIN'))
        {
            $games = GameMaster::where('category', 'matka')->where('created_by', $creator->id)->orderBy('open_time', 'ASC')->get();
        }
        return view('customer.matka_panel_chart', compact('games'));
    }

    public function getMatkaChart_list(Request $request)
    {
        $chartId = $request->id;

        // Fetch data from DB
        $game = GameMaster::find($chartId);
        $panel_chart = GameResult::where('game_id', $chartId)->get();

        return view('customer.matkaChart_list', compact('game', 'panel_chart'));
    }

    public function matka_panel_jodi_chart()
    {
        $user = User::find(Auth::id());
        $creator = User::find($user->created_by);
        $games = [];
        if($creator->hasRole('PARTNER'))
        {
            $admin_ids = User::role('ADMIN')->pluck('id')->toArray();
            $games = GameMaster::where('category', 'matka')->whereIn('created_by', array_merge([$creator->id], $admin_ids))->orderBy('open_time', 'ASC')->get();
            // dd(array_merge([$creator->id], $admin_ids));
        }
        elseif($creator->hasRole('ADMIN'))
        {
            $games = GameMaster::where('category', 'matka')->where('created_by', $creator->id)->orderBy('open_time', 'ASC')->get();
        }
        return view('customer.matka_panel_jodi_chart', compact('games'));
    }

    public function getMatkaJodiChart_list(Request $request)
    {
        $chartId = $request->id;

        // Fetch data from DB
        $game = GameMaster::find($chartId);
        $jodi_chart = GameResult::where('game_id', $chartId)->get();

        return view('customer.matkaJodiChart_list', compact('game', 'jodi_chart'));
    }

    public function satta_result_chart()
    {
        $user = User::find(Auth::id());
        $creator = User::find($user->created_by);
        $games = [];
        if($creator->hasRole('PARTNER'))
        {
            $admin_ids = User::role('ADMIN')->pluck('id')->toArray();
            $games = GameMaster::where('category', 'satta')->whereIn('created_by', array_merge([$creator->id], $admin_ids))->orderBy('open_time', 'ASC')->get();
            // dd(array_merge([$creator->id], $admin_ids));
        }
        elseif($creator->hasRole('ADMIN'))
        {
            $games = GameMaster::where('category', 'satta')->where('created_by', $creator->id)->orderBy('open_time', 'ASC')->get();
        }
        return view('customer.satta_result_chart', compact('games'));
    }

    public function getSattaResultChart_list(Request $request)
    {
        $chartId = $request->id;

        // Fetch data from DB
        $game = GameMaster::find($chartId);
        $result_chart = GameResult::where('game_id', $chartId)->get();

        return view('customer.sattaResultChart_list', compact('game', 'result_chart'));
    }
}
