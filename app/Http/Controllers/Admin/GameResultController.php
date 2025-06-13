<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameResult;
use App\Models\Bids;
use App\Models\BidChild;
use App\Models\GameMode;
use App\Models\Winner;
use App\Models\GameRate;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class GameResultController extends Controller
{
    public function store(Request $request)
    {
        try{
            $request->validate([
                'game_id' => ['required', 'integer'],
                'result_date' => ['required'],
                'open' => ['required', 'digits:3'], // Ensures exactly 3 digits
                'jodi' => ['required'],
                'close' => ['nullable', 'digits:3'], // Ensures exactly 3 digits if provided
            ]);
            
            $id = $request->result_id;
            $result_date = Carbon::parse($request->result_date);
            $game_mode = GameMode::where('category', 'matka')->orderBy('ordering', 'ASC')->get();
            if(empty($id)){
                foreach($game_mode as $mode){
                    $bids = Bids::where(['category'=>'matka', 'game_id'=>$request->game_id, 'game_mode'=>$mode->id, 'game_type'=>'open'])->whereDate('created_at', $result_date)->get();
                    foreach($bids as $bid){
                        foreach($bid->bidchild as $row){
                            if($mode->id == 1 && $row->game_number == $request->jodi){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 3 && $row->game_number == $request->open){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 4 && $row->game_number == $request->open){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 5 && $row->game_number == $request->open){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 6 && $row->game_number == $request->jodi){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            else{
                                $bidchild = BidChild::find($row->id);
                                $bidchild->update(['status'=>2]);
                            }
                        }
                    }
                }

                $request->merge(['created_by' => Auth::id()]);
                $data = $request->all();
                $game_result = GameResult::create($data);

                if($game_result){
                    return response()->json(['status'=>'success',  'message' => 'Game result created successfully.'], 200);
                }
            }
            else{
                $rightSide = substr($request->jodi, 1);
                
                foreach($game_mode as $mode){
                    $bids = Bids::where(['category'=>'matka', 'game_id'=>$request->game_id, 'game_mode'=>$mode->id, 'game_type'=>'close'])->whereDate('created_at', $result_date)->get();
                    foreach($bids as $bid){
                        foreach($bid->bidchild as $row){
                            if($mode->id == 1 && $row->game_number == $rightSide){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 2 && $row->game_number == $request->jodi){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 3 && $row->game_number == $request->close){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 4 && $row->game_number == $request->close){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 5 && $row->game_number == $request->close){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 6 && $row->game_number == $rightSide){
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id])->get()->first();
                                $bidchild = BidChild::find($row->id);
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $user = User::find($bidchild->created_by);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            else{
                                $bidchild = BidChild::find($row->id);
                                $bidchild->update(['status'=>2]);
                            }
                        }
                    }
                }
                // dd($game_mode);

                $request->merge(['updated_by' => Auth::id()]);
                $data = $request->all();
                $game_result = GameResult::find($id);
                $game_result->update($data);

                if($game_result){
                    return response()->json(['status'=>'success',  'message' => 'Game result updated successfully.'], 200);
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function getResultByDate(Request $request)
    {
        try {
            $request->validate([
                'game_id' => ['required', 'integer'],
                'result_date' => ['required'],
            ]);
            // dd($request->game_id);
            $date = $request->result_date; // Ensure correct format
            $result = GameResult::where([
                'game_id' => $request->game_id,
                'result_date' => $date
            ])->first(); // Use `first()` instead of `get()->first()`
    
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'open' => $result->open,
                    'jodi' => $result->jodi,
                    'close' => $result->close,
                    'result_id' => $result->id
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'open' => '',
                    'jodi' => '',
                    'close' => '',
                    'result_id' => ''
                ], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function satta_game_result_store(Request $request)
    {
        try{
            $request->validate([
                'game_id' => ['required', 'integer'],
                'result_date' => ['required'],
                'open' => ['required', 'digits:2'],
            ]);
            
            $result_date = Carbon::parse($request->result_date);
            $game_mode = GameMode::where('category', 'satta')->orderBy('ordering', 'ASC')->get();
            $andarHaruf = substr($request->open, 0, 1);
            $baharHaruf = substr($request->open, 1);
            foreach($game_mode as $mode){
                $bids = Bids::where(['category'=>'satta', 'game_id'=>$request->game_id, 'game_mode'=>$mode->id, 'game_type'=>'open'])->whereDate('created_at', $result_date)->get();
                foreach($bids as $bid){
                    foreach($bid->bidchild as $row){
                        if($mode->id == 16 && $row->game_number == $request->open){
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id])->get()->first();
                            $bidchild = BidChild::find($row->id);
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $user = User::find($bidchild->created_by);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        elseif($mode->id == 17 && $row->game_number == $baharHaruf){
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id])->get()->first();
                            $bidchild = BidChild::find($row->id);
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $user = User::find($bidchild->created_by);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        elseif($mode->id == 18 && $row->game_number == $andarHaruf){
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id])->get()->first();
                            $bidchild = BidChild::find($row->id);
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $user = User::find($bidchild->created_by);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        elseif($mode->id == 19 && $row->game_number == $request->open){
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id])->get()->first();
                            $bidchild = BidChild::find($row->id);
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $user = User::find($bidchild->created_by);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        elseif($mode->id == 20 && $row->game_number == $request->open){
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id])->get()->first();
                            $bidchild = BidChild::find($row->id);
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $user = User::find($bidchild->created_by);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        else{
                            $bidchild = BidChild::find($row->id);
                            $bidchild->update(['status'=>2]);
                        }
                    }
                }
            }

            $request->merge(['created_by' => Auth::id()]);
            $data = $request->all();
            $game_result = GameResult::create($data);

            if($game_result){
                return response()->json(['status'=>'success',  'message' => 'Game result created successfully.'], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function getSattaResultByDate(Request $request)
    {
        try {
            $request->validate([
                'game_id' => ['required', 'integer'],
                'result_date' => ['required'],
            ]);
            // dd($request->game_id);
            $date = $request->result_date; // Ensure correct format
            $result = GameResult::where([
                'game_id' => $request->game_id,
                'result_date' => $date
            ])->first(); // Use `first()` instead of `get()->first()`
    
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'open' => $result->open,
                    'result_id' => $result->id
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'open' => '',
                    'result_id' => ''
                ], 200);
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }
}
