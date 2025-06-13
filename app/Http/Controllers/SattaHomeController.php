<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\GameMaster;
use App\Models\GameMode;
use App\Models\Bids;
use App\Models\BidChild;
use App\Models\User;
use Auth;

class SattaHomeController extends Controller
{
    protected $wallet;
    protected $deposite_wallet;
    protected $bonus_wallet;
    protected $winning_wallet;

    public function __construct() {
        $this->wallet = Auth::user()->deposite_wallet + Auth::user()->bonus_wallet + Auth::user()->winning_wallet;
        $this->deposite_wallet = Auth::user()->deposite_wallet;
        $this->bonus_wallet = Auth::user()->bonus_wallet;
        $this->winning_wallet = Auth::user()->winning_wallet;
    }

    public function index()
    {
        $satta_games = GameMaster::where('category', 'satta')->orderBy('open_time', 'ASC')->get();
        $wallet = number_format($this->wallet, 2);
        return view('customer.satta_home', compact('satta_games', 'wallet'));
    }

    public function game_mode($id)
    {
        $game = GameMaster::find($id);
        $wallet = number_format($this->wallet, 2);
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');

        // Decode closing days, ensuring it's always an array
        $close_days = json_decode($game->closing_days, true) ?? [];

        // Calculate open and close times
        $open_time_spl_game = \Carbon\Carbon::parse($game->open_time)->addHour();
        $open_time_spl = \Carbon\Carbon::parse('00:00:00');
        $open_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->open_time)->subMinutes(5);

        // Determine game closing condition
        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $open_time && $current_time < $open_time_spl_game)
                : ($current_time > $open_time));

        if ($is_closed) {
            return redirect()->route('satta.home');
        }

        // Fetch game modes
        $game_mode = GameMode::where('category', 'satta')->orderBy('ordering', 'ASC')->get();
        return view('customer.satta_game_mode', compact('game', 'game_mode', 'current_time', 'open_time'));
    }

    public function jodi($id,$mode_id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time_spl_game = \Carbon\Carbon::parse($game->open_time)->addHour();
        $open_time_spl = \Carbon\Carbon::parse('00:00:00');
        $open_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->open_time)->subMinutes(5);

        // Determine game closing condition
        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $open_time && $current_time < $open_time_spl_game)
                : ($current_time > $open_time));

        if ($is_closed) {
            return redirect()->route('satta.home');
        }
        else{
            if(empty($game->result->open)){
                return view('customer.satta_mode.jodi', compact('game', 'wallet', 'current_time', 'open_time', 'mode_id'));
            }else{
                return redirect()->route('game.satta.mode', $id);
            }
        }
    }

    public function andarharuf($id,$mode_id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time_spl_game = \Carbon\Carbon::parse($game->open_time)->addHour();
        $open_time_spl = \Carbon\Carbon::parse('00:00:00');
        $open_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->open_time)->subMinutes(5);

        // Determine game closing condition
        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $open_time && $current_time < $open_time_spl_game)
                : ($current_time > $open_time));

        if ($is_closed) {
            return redirect()->route('satta.home');
        }
        return view('customer.satta_mode.andarharuf', compact('game', 'wallet', 'current_time', 'open_time', 'mode_id'));
    }

    public function baharharuf($id,$mode_id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time_spl_game = \Carbon\Carbon::parse($game->open_time)->addHour();
        $open_time_spl = \Carbon\Carbon::parse('00:00:00');
        $open_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->open_time)->subMinutes(5);

        // Determine game closing condition
        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $open_time && $current_time < $open_time_spl_game)
                : ($current_time > $open_time));

        if ($is_closed) {
            return redirect()->route('satta.home');
        }
        return view('customer.satta_mode.baharharuf', compact('game', 'wallet', 'current_time', 'open_time', 'mode_id'));
    }

    public function crossing($id,$mode_id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time_spl_game = \Carbon\Carbon::parse($game->open_time)->addHour();
        $open_time_spl = \Carbon\Carbon::parse('00:00:00');
        $open_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->open_time)->subMinutes(5);

        // Determine game closing condition
        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $open_time && $current_time < $open_time_spl_game)
                : ($current_time > $open_time));

        if ($is_closed) {
            return redirect()->route('satta.home');
        }
        else{
            if(empty($game->result->open)){
                return view('customer.satta_mode.crossing', compact('game', 'wallet', 'current_time', 'open_time', 'mode_id'));
            }else{
                return redirect()->route('game.satta.mode', $id);
            }
        }
    }

    public function cut_crossing($id,$mode_id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time_spl_game = \Carbon\Carbon::parse($game->open_time)->addHour();
        $open_time_spl = \Carbon\Carbon::parse('00:00:00');
        $open_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->open_time)->subMinutes(5);

        // Determine game closing condition
        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $open_time && $current_time < $open_time_spl_game)
                : ($current_time > $open_time));

        if ($is_closed) {
            return redirect()->route('satta.home');
        }
        else{
            if(empty($game->result->open)){
                return view('customer.satta_mode.cut_crossing', compact('game', 'wallet', 'current_time', 'open_time', 'mode_id'));
            }else{
                return redirect()->route('game.satta.mode', $id);
            }
        }
    }

    public function satta_jodi_store(Request $request)
    {
        try{
            $request->validate([
                'game_type' => ['required', 'string', 'max:255',],
                'game_no.*' => ['nullable', 'numeric'],
            ]);

            $gameid = $request->game_id;
            $game = GameMaster::find($gameid);
            $current_time = Carbon::now();
            $current_day = Carbon::now()->format('l');

            $close_days = json_decode($game->closing_days, true) ?? [];

            $open_time_spl_game = \Carbon\Carbon::parse($game->open_time)->addHour();
            $open_time_spl = \Carbon\Carbon::parse('00:00:00');
            $open_time = $game->spl == 1 
                ? Carbon::parse('00:00:00') 
                : Carbon::parse($game->open_time)->subMinutes(5);

            // Determine game closing condition
            $is_closed = in_array($current_day, $close_days) || 
                ($game->spl == 1 
                    ? ($current_time > $open_time && $current_time < $open_time_spl_game)
                    : ($current_time > $open_time));

            if ($is_closed) {
                return redirect()->route('satta.home');
            }
            else{
                // if($current_time > $open_time && $request->game_type == 'open'){
                //     return redirect()->route('satta.home');
                // }
                // else{
                    $userid = Auth::id();
                    $game_type = $request->game_type;
                    $wallet = $this->wallet;
                    $game_no_arr = $request->game_no;

                    $points = 0;
                    foreach($game_no_arr as $row){
                        if(!empty($row) && $row >= 1){
                            $points += $row;
                        }
                    }
                    $current_balance = ($wallet - $points);

                    if($points > 0 && $points <= $wallet){
                        $payload = [
                            'category' => 'satta',
                            'game_id' => $gameid,
                            'game_mode' => $request->game_mode,
                            'game_type' => $game_type,
                            'wallet_current_balance' => $current_balance,
                            'wallet_prev_balance' => $wallet,
                            'total_points' => $points,
                            'created_by' => $userid,
                        ];
                        $bids = Bids::create($payload);
                        $bidid = $bids->id;
                        
                        foreach($game_no_arr as $key => $value){
                            if(!empty($value) && $value >= 1){
                                $data = [
                                    'bid_id' => $bidid,
                                    'game_number' => $key,
                                    'points' => $value,
                                    'prev_balance' => $wallet,
                                    'current_balance' => $wallet - $value,
                                    'created_by' => $userid,
                                ];
                                BidChild::create($data);
                                $wallet -= $value;
                            }
                        }

                        $depositWallet = $this->deposite_wallet;
                        $bonusWallet = $this->bonus_wallet;
                        $winningWallet = $this->winning_wallet;

                        // Deduct points with priority
                        if ($points > 0) {
                            $deductFromDeposit = min($points, $depositWallet);
                            $depositWallet -= $deductFromDeposit;
                            $points -= $deductFromDeposit;
                        }

                        if ($points > 0) {
                            $deductFromBonus = min($points, $bonusWallet);
                            $bonusWallet -= $deductFromBonus;
                            $points -= $deductFromBonus;
                        }

                        if ($points > 0) {
                            $deductFromWinning = min($points, $winningWallet);
                            $winningWallet -= $deductFromWinning;
                            $points -= $deductFromWinning;
                        }
                        
                        $user = Auth::user();
                        $user->update([
                            'deposite_wallet' => $depositWallet,
                            'bonus_wallet' => $bonusWallet,
                            'winning_wallet' => $winningWallet,
                        ]);

                        if($bids){
                            return response()->json(['status'=>'success',  'message' => 'Bid successfully.'], 200);
                        }
                    }
                    else{
                        return response()->json(['status'=>'error',  'message' => 'You have no balance. Please recharge.']);
                    }
                // }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }
}
