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
use App\Models\GameMaster;
use Carbon\Carbon;
use Auth;
use App\Models\Notification;

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
            $game = GameMaster::find($request->game_id);
            $result_date = Carbon::parse($request->result_date);
            $game_mode = GameMode::where('category', 'matka')->orderBy('ordering', 'ASC')->get();
            if(empty($id)){
                foreach($game_mode as $mode){
                    $bids = Bids::where(['category'=>'matka', 'game_id'=>$request->game_id, 'game_mode'=>$mode->id, 'game_type'=>'open'])->whereDate('created_at', $result_date)->get();
                    foreach($bids as $bid){
                        foreach($bid->bidchild as $row){
                            if($mode->id == 1 && $row->game_number == $request->jodi){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3',
                                    'result_date' => $result_date,
                                    'created_by' => Auth::id()
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);                                    
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 3 && $row->game_number == $request->open){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3',
                                    'result_date' => $result_date,
                                    'created_by' => Auth::id()
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 4 && $row->game_number == $request->open){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3',
                                    'result_date' => $result_date,
                                    'created_by' => Auth::id()
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 5 && $row->game_number == $request->open){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3',
                                    'result_date' => $result_date,
                                    'created_by' => Auth::id()
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 6 && $row->game_number == $request->jodi){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3',
                                    'result_date' => $result_date,
                                    'created_by' => Auth::id()
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
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
                    
                $notificationDataOpen = [
                    'title'         => $game->name,
                    'description'   => 'Open result is '.$request->open,
                    'event_type'    => '5', // 5 for game result update notification
                    'result_date' => $result_date,
                    'created_by'    => Auth::id(),
                ];

                $notificationDataJodi = [
                    'title'         => $game->name,
                    'description'   => 'Jodi result is '.$request->jodi,
                    'event_type'    => '5', // 5 for game result update notification
                    'result_date' => $result_date,
                    'created_by'    => Auth::id(),
                ];
                Notification::create($notificationDataOpen);
                Notification::create($notificationDataJodi);

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
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3', // 3 for game result update notification
                                    'result_date' => $result_date,
                                    'created_by'    => Auth::id(),
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 2 && $row->game_number == $request->jodi){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3', // 3 for game result update notification
                                    'result_date' => $result_date,
                                    'created_by'    => Auth::id(),
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 3 && $row->game_number == $request->close){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3', // 3 for game result update notification
                                    'result_date' => $result_date,
                                    'created_by'    => Auth::id(),
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 4 && $row->game_number == $request->close){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3', // 3 for game result update notification
                                    'result_date' => $result_date,
                                    'created_by'    => Auth::id(),
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 5 && $row->game_number == $request->close){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3', // 3 for game result update notification
                                    'result_date' => $result_date,
                                    'created_by'    => Auth::id(),
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
                                    $wining = ($user->winning_wallet + $win_amount);
                                    $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                    if($user){
                                        $bidchild->update(['status'=>1]);
                                    }
                                }
                            }
                            elseif($mode->id == 6 && $row->game_number == $rightSide){
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where(['category'=>'matka', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                                $win_amount = $game_rate->rate * $bidchild->points;
                                $data = [
                                    'user_id'=>$bidchild->created_by,
                                    'bidchild_id'=>$bidchild->id,
                                    'win_amount'=>$win_amount,
                                ];
                                $notificationData = [
                                    'title'         => $game->name.' ('.$mode->name.')',
                                    'description'   => 'Congratulation you are win rupees '.$win_amount,
                                    'user_id'       => $bidchild->created_by,
                                    'winer_user_id' => $bidchild->created_by,
                                    'event_type'    => '3', // 3 for game result update notification
                                    'result_date' => $result_date,
                                    'created_by'    => Auth::id(),
                                ];
                                $winner = Winner::create($data);
                                if($winner){
                                    $notification = Notification::create($notificationData);
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

                $notificationDataClose = [
                    'title'         => $game->name,
                    'description'   => 'Close result is '.$request->close,
                    'event_type'    => '5', // 5 for game result update notification
                    'result_date' => $result_date,
                    'created_by'    => Auth::id(),
                ];

                $notificationDataJodi = [
                    'title'         => $game->name,
                    'description'   => 'Jodi result is '.$request->jodi,
                    'event_type'    => '5', // 5 for game result update notification
                    'result_date' => $result_date,
                    'created_by'    => Auth::id(),
                ];
                Notification::create($notificationDataClose);
                Notification::create($notificationDataJodi);            
                
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
            
            $result = $request->open;
            $game = GameMaster::find($request->game_id);
            $result_date = Carbon::parse($request->result_date);
            $game_mode = GameMode::where('category', 'satta')->orderBy('ordering', 'ASC')->get();
            $andarHaruf = substr($result, 0, 1);
            $baharHaruf = substr($result, 1);
            foreach($game_mode as $mode){
                $bids = Bids::where(['category'=>'satta', 'game_id'=>$request->game_id, 'game_mode'=>$mode->id, 'game_type'=>'open'])->whereDate('created_at', $result_date)->get();
                foreach($bids as $bid){
                    foreach($bid->bidchild as $row){
                        if($mode->id == 16 && $row->game_number == $result){
                            $bidchild = BidChild::find($row->id);
                            $user = User::find($bidchild->created_by);
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $notificationData = [
                                'title'         => $game->name.' ('.$mode->name.')',
                                'description'   => 'Congratulation you are win rupees '.$win_amount,
                                'user_id'       => $bidchild->created_by,
                                'winer_user_id' => $bidchild->created_by,
                                'event_type'    => '4',
                                'result_date' => $result_date,
                                'created_by'    => Auth::id(),
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $notification = Notification::create($notificationData);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        elseif($mode->id == 17 && $row->game_number == $baharHaruf){
                            $bidchild = BidChild::find($row->id);
                            $user = User::find($bidchild->created_by);
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $notificationData = [
                                'title'         => $game->name.' ('.$mode->name.')',
                                'description'   => 'Congratulation you are win rupees '.$win_amount,
                                'user_id'       => $bidchild->created_by,
                                'winer_user_id' => $bidchild->created_by,
                                'event_type'    => '4',
                                'result_date' => $result_date,
                                'created_by'    => Auth::id(),
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $notification = Notification::create($notificationData);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        elseif($mode->id == 18 && $row->game_number == $andarHaruf){
                            $bidchild = BidChild::find($row->id);
                            $user = User::find($bidchild->created_by);
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $notificationData = [
                                'title'         => $game->name.' ('.$mode->name.')',
                                'description'   => 'Congratulation you are win rupees '.$win_amount,
                                'user_id'       => $bidchild->created_by,
                                'winer_user_id' => $bidchild->created_by,
                                'event_type'    => '4',
                                'result_date' => $result_date,
                                'created_by'    => Auth::id(),
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $notification = Notification::create($notificationData);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        elseif($mode->id == 19 && $row->game_number == $result){
                            $bidchild = BidChild::find($row->id);
                            $user = User::find($bidchild->created_by);
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $notificationData = [
                                'title'         => $game->name.' ('.$mode->name.')',
                                'description'   => 'Congratulation you are win rupees '.$win_amount,
                                'user_id'       => $bidchild->created_by,
                                'winer_user_id' => $bidchild->created_by,
                                'event_type'    => '4',
                                'result_date' => $result_date,
                                'created_by'    => Auth::id(),
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $notification = Notification::create($notificationData);
                                $wining = ($user->winning_wallet + $win_amount);
                                $user->update(['winning_wallet'=>$wining, 'updated_by'=>Auth::id()]);
                                if($user){
                                    $bidchild->update(['status'=>1]);
                                }
                            }
                        }
                        elseif($mode->id == 20 && $row->game_number == $result){
                            $bidchild = BidChild::find($row->id);
                            $user = User::find($bidchild->created_by);
                            $game_rate = GameRate::where(['category'=>'satta', 'gamemode'=>$mode->id, 'created_by'=>$user->created_by])->get()->first();
                            $win_amount = $game_rate->rate * $bidchild->points;
                            $data = [
                                'user_id'=>$bidchild->created_by,
                                'bidchild_id'=>$bidchild->id,
                                'win_amount'=>$win_amount,
                            ];
                            $notificationData = [
                                'title'         => $game->name.' ('.$mode->name.')',
                                'description'   => 'Congratulation you are win rupees '.$win_amount,
                                'user_id'       => $bidchild->created_by,
                                'winer_user_id' => $bidchild->created_by,
                                'event_type'    => '4',
                                'result_date' => $result_date,
                                'created_by'    => Auth::id(),
                            ];
                            $winner = Winner::create($data);
                            if($winner){
                                $notification = Notification::create($notificationData);
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

            $notificationData = [
                'title'         => $game->name,
                'description'   => 'Result is: ' . $result,
                'event_type'    => '6',
                'result_date' => $result_date,
                'created_by'    => Auth::id(),
            ];
            $notification = Notification::create($notificationData);

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
