<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\GameMaster;
use App\Models\GameResult;
use App\Models\GameMode;
use App\Models\Bids;
use App\Models\BidChild;
use Auth;

class MatkaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = GameMaster::where('category', 'matka')->orderBy('open_time', 'ASC')->get();
        return view('admin.matka_game.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.matka_game.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'category' => ['required', 'string', 'max:255',],
                'name' => ['required', 'string', 'max:255', 'unique:game_masters'],
                'priority' => ['required', 'string', 'max:255'],
                'open_time' => ['required', 'date_format:H:i'], // Time field validation
                'close_time' => ['required', 'date_format:H:i'], // Ensure close_time is later , 'after:open_time'
                'spl' => ['nullable', 'integer'],
                'closing_days.*' => ['nullable', 'string', 'max:255'],
            ]);

            $request->merge(['created_by' => Auth::id()]);
            $data = $request->all();
            $data['closing_days'] = json_encode($request->input('closing_days'));
            
            $game = GameMaster::create($data);

            if($game){
                return response()->json(['status'=>'success',  'message' => 'Game created successfully.'], 200);
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
        $data = GameMaster::find($id);
        return view('admin.matka_game.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->merge([
                'open_time' => date('H:i', strtotime($request->open_time)),
                'close_time' => date('H:i', strtotime($request->close_time))
            ]);

            $request->validate([
                'category' => ['required', 'string', 'max:255',],
                'name' => ['required', 'string', 'max:255', 'unique:game_masters,name,'.$id],
                'priority' => ['required', 'string', 'max:255'],
                'open_time' => ['required', 'date_format:H:i'], // Time field validation
                'close_time' => ['required', 'date_format:H:i'], // Ensure close_time is later
                'spl' => ['nullable', 'integer'],
                'closing_days.*' => ['nullable', 'string', 'max:255'],
            ]);

            $request->merge(['updated_by' => Auth::id()]);
            $data = $request->all();
            $data['closing_days'] = json_encode($request->input('closing_days'));
            
            $game = GameMaster::find($id);
            $game->update($data);

            if($game){
                return response()->json(['status'=>'success',  'message' => 'Game updated successfully.'], 200);
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
        $game = GameMaster::find($id);

        if (!$game) {
            return response()->json(['status'=>'failed', 'message'=>'Game not found.']);
        }else{
            $game->delete();
            return response()->json(['status'=>'success', 'message'=>'Game deleted successfully.']);
        }
    }

    public function show_bid(Request $request, $id)
    {
        $game_id = $id;
        $date_open = !empty($request->get('date-filter')) ? $request->get('date-filter') : Carbon::today();

        $game_mode = GameMode::where('category', 'matka')->orderBy('ordering', 'ASC')->get();
        $bids = Bids::where(['category'=>'matka', 'game_id'=>$id, 'game_type'=>'open'])->whereDate('created_at', $date_open)->get();
        
        $totalpointsByGame = [];
        $totalusersByGame = [];
        $bid_no = [];

        $groupedBids = $bids->groupBy(function ($bid) {
            return $bid->game_mode;
        });

        foreach ($groupedBids as $groupKey => $group) {
            $totalpointsByGame[$groupKey] = $group->sum('total_points');
            $totalusersByGame[$groupKey] = $group->pluck('created_by')->unique()->count();
            $bidIds = $group->pluck('id');
    
            // Query BidChild using the collected bid IDs
            $bid_no[$groupKey] = BidChild::whereIn('bid_id', $bidIds)
            ->select('game_number', 'points') // Fetch only required columns
            ->get() // Retrieve the data
            ->groupBy('game_number') // Group the data by game_number
            ->map(function ($groupbid) {
                return [
                    'game_number' => $groupbid->first()->game_number, // Take the game_number from the first entry
                    'total_points' => $groupbid->sum('points'), // Calculate the sum of points for the group
                ];
            })
            ->sortBy('total_points')
            ->values();
        }

        //Close type data
        $game = GameMaster::find($id);
        $current_time = Carbon::now();
        $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
        $close_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->close_time)->subMinutes(5);
        if($current_time > $close_time && $current_time < $close_time_spl_game){
            $date = $game->spl == 1 ? Carbon::parse($date_open)->subDay() : $date_open;
        }else{
            $date = $date_open;
        }

        $bids_close = Bids::where(['category'=>'matka', 'game_id'=>$id, 'game_type'=>'close'])->whereDate('created_at', $date)->get();
        
        $totalpoints_close = [];
        $totalusers_close = [];
        $bid_no_close = [];

        $groupedBids_close = $bids_close->groupBy(function ($bid_close) {
            return $bid_close->game_mode;
        });

        foreach ($groupedBids_close as $groupKey_close => $group_close) {
            $totalpoints_close[$groupKey_close] = $group_close->sum('total_points');
            $totalusers_close[$groupKey_close] = $group_close->pluck('created_by')->unique()->count();
            $bidIds_close = $group_close->pluck('id');
    
            // Query BidChild using the collected bid IDs
            $bid_no_close[$groupKey_close] = BidChild::whereIn('bid_id', $bidIds_close)
            ->select('game_number', 'points') // Fetch only required columns
            ->get() // Retrieve the data
            ->groupBy('game_number') // Group the data by game_number
            ->map(function ($groupbid_close) {
                return [
                    'game_number' => $groupbid_close->first()->game_number, // Take the game_number from the first entry
                    'total_points' => $groupbid_close->sum('points'), // Calculate the sum of points for the group
                ];
            })
            ->sortBy('total_points')
            ->values();
        }

        // dd($bid_no);
        return view('admin.matka_game.bid', compact('game_mode', 'game_id', 'date', 'totalpointsByGame', 'totalusersByGame', 'bid_no', 'totalpoints_close', 'totalusers_close', 'bid_no_close'));
    }

    public function panel_chart($id)
    {
        $game = GameMaster::find($id);
        $panel_chart = GameResult::where('game_id', $id)->get();
        return view('admin.matka_game.panel_chart', compact('game', 'panel_chart'));
    }

    public function jodi_chart($id)
    {
        $game = GameMaster::find($id);
        $jodi_chart = GameResult::where('game_id', $id)->get();
        return view('admin.matka_game.jodi_chart', compact('game', 'jodi_chart'));
    }
}
