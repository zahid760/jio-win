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

class SattaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = GameMaster::where('category', 'satta')->orderBy('open_time', 'ASC')->get();
        return view('admin.satta_game.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.satta_game.add');
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
        return view('admin.satta_game.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->merge([
                'open_time' => date('H:i', strtotime($request->open_time)),
            ]);

            $request->validate([
                'category' => ['required', 'string', 'max:255',],
                'name' => ['required', 'string', 'max:255', 'unique:game_masters,name,'.$id],
                'priority' => ['required', 'string', 'max:255'],
                'open_time' => ['required', 'date_format:H:i'], // Time field validation
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
        $date_filter = !empty($request->get('date-filter')) ? $request->get('date-filter') : Carbon::today();

        $game_mode = GameMode::where('category', 'satta')->orderBy('ordering', 'ASC')->get();
        $bids = Bids::where(['category'=>'satta', 'game_id'=>$id, 'game_type'=>'open'])->whereDate('created_at', Carbon::parse($date_filter))->get();
        
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

        return view('admin.satta_game.bid', compact('game_mode', 'game_id', 'date_filter', 'totalpointsByGame', 'totalusersByGame', 'bid_no'));
    }

    public function result_chart($id)
    {
        $game = GameMaster::find($id);
        $result_chart = GameResult::where('game_id', $id)->get();
        return view('admin.satta_game.result_chart', compact('game', 'result_chart'));
    }
}
