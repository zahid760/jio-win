<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameMaster;
use App\Models\Bids;
use App\Models\GameResult;
use \Carbon\Carbon;
use Auth;

class BidHistoryController extends Controller
{
    public function index()
    {
        return view('customer.my_bids');
    }

    public function bid_history()
    {
        $matka_games = GameMaster::where('category', 'matka')->orderBy('open_time', 'ASC')->get();
        return view('customer.bid_history', compact('matka_games'));
    }

    public function bid_history_filter(Request $request)
    {
        try{
            $query = Bids::with('game', 'gamemode', 'bidchild')
                ->where(['category'=>'matka', 'created_by'=>Auth::user()->id]);

            if (!empty($request->game_type) && count($request->game_type) > 0) {
                $query->whereIn('game_type', $request->game_type);
            }

            if (!empty($request->winning_status) && count($request->winning_status) > 0) {
                // Add whereHas to filter by status in the bidchild table
                $query->whereHas('bidchild', function ($childQuery) use ($request) {
                    $childQuery->whereIn('status', $request->winning_status);
                });
            }

            if (!empty($request->by_game) && count($request->by_game) > 0) {
                $query->whereIn('game_id', $request->by_game);
            }

            $bids = $query->orderBy('id', 'DESC')->get();
            if($query){
                return response()->json(['status'=>'success',  'data' => $bids], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function passbook()
    {
        $bids = Bids::with('game', 'gamemode', 'bidchild')->where('created_by', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('customer.passbook', compact('bids'));
    }

    public function game_result()
    {
        return view('customer.game_result');
    }

    public function get_game_result(Request $request)
    {
        try{
            $dynamicDate = $request->date ? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString();
            
            $matka_games = GameMaster::with(['game_result_history' => function ($query) use ($dynamicDate) {
                $query->whereDate('result_date', $dynamicDate);
            }])->where('category', 'matka')->orderBy('open_time', 'ASC')->get();

            if($matka_games){
                return response()->json(['status'=>'success',  'data' => $matka_games], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function satta_bid_history()
    {
        $satta_games = GameMaster::where('category', 'satta')->orderBy('open_time', 'ASC')->get();
        return view('customer.satta_bid_history', compact('satta_games'));
    }

    public function satta_bid_history_filter(Request $request)
    {
        try{
            $query = Bids::with('game', 'gamemode', 'bidchild')
                ->where(['category'=>'satta', 'created_by'=>Auth::user()->id, 'game_type'=>'open']);

            if (!empty($request->winning_status) && count($request->winning_status) > 0) {
                // Add whereHas to filter by status in the bidchild table
                $query->whereHas('bidchild', function ($childQuery) use ($request) {
                    $childQuery->whereIn('status', $request->winning_status);
                });
            }

            if (!empty($request->by_game) && count($request->by_game) > 0) {
                $query->whereIn('game_id', $request->by_game);
            }

            $bids = $query->orderBy('id', 'DESC')->get();
            if($query){
                return response()->json(['status'=>'success',  'data' => $bids], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function satta_game_result()
    {
        return view('customer.satta_game_result');
    }

    public function get_satta_game_result(Request $request)
    {
        try{
            $dynamicDate = $request->date ? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString();
            
            $matka_games = GameMaster::with(['game_result_history' => function ($query) use ($dynamicDate) {
                $query->whereDate('result_date', $dynamicDate);
            }])->where('category', 'satta')->orderBy('open_time', 'ASC')->get();

            if($matka_games){
                return response()->json(['status'=>'success',  'data' => $matka_games], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }
}
