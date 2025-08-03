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
use App\Models\Passbook;
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
            $game_modes = GameMode::where('category', 'matka')->orderBy('ordering', 'ASC')->get();

            if(empty($id)){
                $winningChecks = [
                    1 => $request->jodi,
                    3 => $request->open,
                    4 => $request->open,
                    5 => $request->open,
                    6 => $request->jodi,
                ];

                foreach ($game_modes as $mode) {
                    $bids = Bids::where([
                        'category' => 'matka',
                        'game_id' => $request->game_id,
                        'game_mode' => $mode->id,
                        'game_type' => 'open'
                    ])->whereDate('created_at', $result_date)->get();

                    foreach ($bids as $bid) {
                        foreach ($bid->bidchild as $row) {
                            $bidchild = BidChild::find($row->id);

                            if (isset($winningChecks[$mode->id]) && $row->game_number == $winningChecks[$mode->id]) {
                                $user = User::find($bidchild->created_by);
                                $game_rate = GameRate::where([
                                    'category' => 'matka',
                                    'gamemode' => $mode->id,
                                    'created_by' => $user->created_by
                                ])->first();

                                $win_amount = $game_rate->rate * $bidchild->points;

                                $this->processMatkaWin($bidchild, $user, $game_rate, $win_amount, $game, $mode, $bid, $result_date);
                            } else {
                                $bidchild->update(['status' => 2]);
                            }
                        }
                    }
                }

                // Prepare common fields
                $commonNotificationData = [
                    'title'       => $game->name,
                    'event_type'  => '5', // Game result update
                    'result_date' => $result_date,
                    'created_by'  => Auth::id(),
                ];

                // Send "Open" result notification
                Notification::create(array_merge($commonNotificationData, [
                    'description' => 'Open result is ' . $request->open,
                ]));

                // Send "Jodi" result notification
                Notification::create(array_merge($commonNotificationData, [
                    'description' => 'Jodi result is ' . $request->jodi,
                ]));

                $request->merge(['created_by' => Auth::id()]);
                $data = $request->all();
                $game_result = GameResult::create($data);

                if($game_result){
                    return response()->json(['status'=>'success',  'message' => 'Game result created successfully.'], 200);
                }
            }
            else{
                $rightSide = substr($request->jodi, 1);

                $matchConditions = [
                    1 => $rightSide,
                    2 => $request->jodi,
                    3 => $request->close,
                    4 => $request->close,
                    5 => $request->close,
                    6 => $rightSide,
                ];

                foreach ($game_modes as $mode) {
                    $bids = Bids::where([
                        'category'   => 'matka',
                        'game_id'    => $request->game_id,
                        'game_mode'  => $mode->id,
                        'game_type'  => 'close',
                    ])->whereDate('created_at', $result_date)->get();

                    foreach ($bids as $bid) {
                        foreach ($bid->bidchild as $row) {
                            $expectedValue = $matchConditions[$mode->id] ?? null;

                            if ($row->game_number == $expectedValue) {
                                $bidchild = BidChild::find($row->id);
                                $user = User::find($bidchild->created_by);
                                $userWallet = $user->deposite_wallet + $user->bonus_wallet + $user->winning_wallet;

                                $game_rate = GameRate::where([
                                    'category'   => 'matka',
                                    'gamemode'   => $mode->id,
                                    'created_by' => $user->created_by,
                                ])->first();

                                $win_amount = $game_rate->rate * $bidchild->points;

                                $winner = Winner::create([
                                    'user_id'     => $bidchild->created_by,
                                    'bidchild_id' => $bidchild->id,
                                    'win_amount'  => $win_amount,
                                ]);

                                if ($winner) {
                                    Notification::create([
                                        'title'         => $game->name . ' (' . $mode->name . ')',
                                        'description'   => 'Congratulation you are win rupees ' . $win_amount,
                                        'user_id'       => $bidchild->created_by,
                                        'winer_user_id' => $bidchild->created_by,
                                        'event_type'    => '3',
                                        'result_date'   => $result_date,
                                        'created_by'    => Auth::id(),
                                    ]);

                                    $user->update([
                                        'winning_wallet' => $user->winning_wallet + $win_amount,
                                        'updated_by'     => Auth::id(),
                                    ]);

                                    $bidchild->update(['status' => 1]);

                                    Passbook::create([
                                        'user_id'         => $bidchild->created_by,
                                        'bid_id'          => $bidchild->bid_id,
                                        'game_number'     => $bidchild->game_number,
                                        'points'          => $bidchild->points,
                                        'prev_balance'    => $userWallet,
                                        'current_balance' => $userWallet + $win_amount,
                                        'status'          => 1,
                                        'winner_id'       => $winner->id,
                                        'created_by'      => Auth::id(),
                                    ]);
                                }
                            } else {
                                $bidchild = BidChild::find($row->id);
                                $bidchild->update(['status' => 2]);
                            }
                        }
                    }
                }

                // Prepare common fields
                $commonNotificationData = [
                    'title'       => $game->name,
                    'event_type'  => '5', // Game result update
                    'result_date' => $result_date,
                    'created_by'  => Auth::id(),
                ];

                // Send "Open" result notification
                Notification::create(array_merge($commonNotificationData, [
                    'description' => 'Close result is ' . $request->close,
                ]));

                // Send "Jodi" result notification
                Notification::create(array_merge($commonNotificationData, [
                    'description' => 'Jodi result is ' . $request->jodi,
                ]));
                
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

    private function processMatkaWin($bidchild, $user, $game_rate, $win_amount, $game, $mode, $bid, $result_date)
    {
        $userWallet = $user->deposite_wallet + $user->bonus_wallet + $user->winning_wallet;
        $winnerData = [
            'user_id' => $bidchild->created_by,
            'bidchild_id' => $bidchild->id,
            'win_amount' => $win_amount,
        ];

        $winner = Winner::create($winnerData);

        if ($winner) {
            Notification::create([
                'title' => $game->name . ' (' . $mode->name . ')',
                'description' => 'Congratulation you are win rupees ' . $win_amount,
                'user_id' => $bidchild->created_by,
                'winer_user_id' => $bidchild->created_by,
                'event_type' => '3',
                'result_date' => $result_date,
                'created_by' => Auth::id(),
            ]);

            $user->update([
                'winning_wallet' => $user->winning_wallet + $win_amount,
                'updated_by' => Auth::id()
            ]);

            $bidchild->update(['status' => 1]);
            
            Passbook::create([
                'user_id' => $bidchild->created_by,
                'bid_id' => $bidchild->bid_id,
                'game_number' => $bidchild->game_number,
                'points' => $bidchild->points,
                'prev_balance' => $userWallet,
                'current_balance' => $userWallet + $win_amount,
                'winner_id' => $winner->id,
                'status' => 1,
                'created_by' => Auth::id()
            ]);
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
            $game_modes = GameMode::where('category', 'satta')->orderBy('ordering', 'ASC')->get();
            $andarHaruf = substr($result, 0, 1);
            $baharHaruf = substr($result, 1);

            foreach ($game_modes as $mode) {
                $bids = Bids::where([
                    'category' => 'satta',
                    'game_id' => $request->game_id,
                    'game_mode' => $mode->id,
                    'game_type' => 'open',
                ])->whereDate('created_at', $result_date)->get();

                foreach ($bids as $bid) {
                    foreach ($bid->bidchild as $row) {

                        // Determine if the bid is a winning one
                        $isWin = false;
                        if ($mode->id == 16 && $row->game_number == $result) $isWin = true;
                        elseif ($mode->id == 17 && $row->game_number == $baharHaruf) $isWin = true;
                        elseif ($mode->id == 18 && $row->game_number == $andarHaruf) $isWin = true;
                        elseif ($mode->id == 19 && $row->game_number == $result) $isWin = true;
                        elseif ($mode->id == 20 && $row->game_number == $result) $isWin = true;

                        $bidchild = BidChild::find($row->id);

                        if ($isWin) {
                            $this->processWinningBid($bidchild, $mode, $game, $result_date);
                        } else {
                            $bidchild->update(['status' => 2]);
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

    private function processWinningBid($bidchild, $mode, $game, $result_date)
    {
        $user = User::find($bidchild->created_by);
        $userWallet = $user->deposite_wallet + $user->bonus_wallet + $user->winning_wallet;

        $game_rate = GameRate::where([
            'category' => 'satta',
            'gamemode' => $mode->id,
            'created_by' => $user->created_by
        ])->first();

        $win_amount = $game_rate->rate * $bidchild->points;

        $winner = Winner::create([
            'user_id' => $bidchild->created_by,
            'bidchild_id' => $bidchild->id,
            'win_amount' => $win_amount,
        ]);

        if ($winner) {
            Notification::create([
                'title' => $game->name . ' (' . $mode->name . ')',
                'description' => 'Congratulation you are win rupees ' . $win_amount,
                'user_id' => $bidchild->created_by,
                'winer_user_id' => $bidchild->created_by,
                'event_type' => '4',
                'result_date' => $result_date,
                'created_by' => Auth::id(),
            ]);

            $user->update([
                'winning_wallet' => $user->winning_wallet + $win_amount,
                'updated_by' => Auth::id(),
            ]);

            $bidchild->update(['status' => 1]);

            Passbook::create([
                'user_id' => $bidchild->created_by,
                'bid_id' => $bidchild->bid_id,
                'game_number' => $bidchild->game_number,
                'points' => $bidchild->points,
                'prev_balance' => $userWallet,
                'current_balance' => $userWallet + $win_amount,
                'winner_id' => $winner->id,
                'status' => 1,
                'created_by' => Auth::id()
            ]);
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
