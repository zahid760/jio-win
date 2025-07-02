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

class HomeController extends Controller
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
        // $matka_games = GameMaster::where('category', 'matka')->orderBy('open_time', 'ASC')->get();

        $user = User::find(Auth::id());
        $creator = User::find($user->created_by);
        $matka_games = [];
        if($creator->hasRole('PARTNER'))
        {
            $admin_ids = User::role('ADMIN')->pluck('id')->toArray();
            $matka_games = GameMaster::where('category', 'matka')->whereIn('created_by', array_merge([$creator->id], $admin_ids))->orderBy('open_time', 'ASC')->get();
        }
        elseif($creator->hasRole('ADMIN'))
        {
            $matka_games = GameMaster::where('category', 'matka')->where('created_by', $creator->id)->orderBy('open_time', 'ASC')->get();
        }
        $wallet = number_format($this->wallet, 2);
        return view('customer.home', compact('matka_games', 'wallet'));
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
        $open_time = Carbon::parse($game->open_time)->subMinutes(5);
        $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
        $close_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->close_time)->subMinutes(5);

        // Determine game closing condition
        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                : ($current_time > $close_time));

        if ($is_closed) {
            return redirect()->route('home');
        }

        // Fetch game modes
        $game_mode = GameMode::where('category', 'matka')->orderBy('ordering', 'ASC')->get();
        return view('customer.game_mode', compact('game', 'game_mode', 'current_time', 'open_time', 'close_time'));
    }

    public function single_digit($id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time = Carbon::parse($game->open_time)->subMinutes(5);
        $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
        $close_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->close_time)->subMinutes(5);

        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                : ($current_time > $close_time));

        if ($is_closed) {
            return redirect()->route('home');
        }
        return view('customer.mode.single_digit', compact('game', 'wallet', 'current_time', 'open_time', 'close_time'));
    }

    public function single_digit_store(Request $request)
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

            $open_time = Carbon::parse($game->open_time)->subMinutes(5);
            $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
            $close_time = $game->spl == 1 
                ? Carbon::parse('00:00:00') 
                : Carbon::parse($game->close_time)->subMinutes(5);

            $is_closed = in_array($current_day, $close_days) || 
                ($game->spl == 1 
                    ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                    : ($current_time > $close_time));

            if ($is_closed) {
                return redirect()->route('home');
            }
            else{
                if($current_time > $open_time && $request->game_type == 'open'){
                    return redirect()->route('home');
                }
                else{
                    $userid = Auth::id();
                    $game_type = $request->game_type;
                    $wallet = $this->wallet;
                    $game_no_arr = $request->game_no;

                    $points = 0;
                    foreach($game_no_arr as $row){
                        if(!empty($row) && $row >= 5){
                            $points += $row;
                        }
                    }
                    $current_balance = ($wallet - $points);

                    if($points > 0 && $points <= $wallet){
                        $payload = [
                            'category' => 'matka',
                            'game_id' => $gameid,
                            'game_mode' => 1,
                            'game_type' => $game_type,
                            'wallet_current_balance' => $current_balance,
                            'wallet_prev_balance' => $wallet,
                            'total_points' => $points,
                            'created_by' => $userid,
                        ];
                        $bids = Bids::create($payload);
                        $bidid = $bids->id;
                        
                        foreach($game_no_arr as $key => $value){
                            if(!empty($value) && $value >= 5){
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
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function jodi($id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time = Carbon::parse($game->open_time)->subMinutes(5);
        $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
        $close_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->close_time)->subMinutes(5);

        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                : ($current_time > $close_time));

        if ($is_closed) {
            return redirect()->route('home');
        }
        else{
            if(empty($game->result->open)){
                return view('customer.mode.jodi', compact('game', 'wallet', 'current_time', 'open_time', 'close_time'));
            }else{
                return redirect()->route('game.mode', $id);
            }
        }
    }

    public function jodi_store(Request $request)
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

            $open_time = Carbon::parse($game->open_time)->subMinutes(5);
            $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
            $close_time = $game->spl == 1 
                ? Carbon::parse('00:00:00') 
                : Carbon::parse($game->close_time)->subMinutes(5);

            $is_closed = in_array($current_day, $close_days) || 
                ($game->spl == 1 
                    ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                    : ($current_time > $close_time));

            if ($is_closed) {
                return redirect()->route('home');
            }
            else{
                if($current_time > $open_time && $request->game_type == 'open'){
                    return redirect()->route('home');
                }
                else{
                    $userid = Auth::id();
                    $game_type = $request->game_type;
                    $wallet = $this->wallet;
                    $game_no_arr = $request->game_no;

                    $points = 0;
                    foreach($game_no_arr as $row){
                        if(!empty($row) && $row >= 5){
                            $points += $row;
                        }
                    }
                    $current_balance = ($wallet - $points);

                    if($points > 0 && $points <= $wallet){
                        $payload = [
                            'category' => 'matka',
                            'game_id' => $gameid,
                            'game_mode' => 2,
                            'game_type' => $game_type,
                            'wallet_current_balance' => $current_balance,
                            'wallet_prev_balance' => $wallet,
                            'total_points' => $points,
                            'created_by' => $userid,
                        ];
                        $bids = Bids::create($payload);
                        $bidid = $bids->id;
                        
                        foreach($game_no_arr as $key => $value){
                            if(!empty($value) && $value >= 5){
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
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function single_pana($id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time = Carbon::parse($game->open_time)->subMinutes(5);
        $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
        $close_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->close_time)->subMinutes(5);

        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                : ($current_time > $close_time));

        if ($is_closed) {
            return redirect()->route('home');
        }
        else{
            return view('customer.mode.single_pana', compact('game', 'wallet', 'current_time', 'open_time', 'close_time'));
        }
    }

    public function single_pana_store(Request $request)
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

            $open_time = Carbon::parse($game->open_time)->subMinutes(5);
            $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
            $close_time = $game->spl == 1 
                ? Carbon::parse('00:00:00') 
                : Carbon::parse($game->close_time)->subMinutes(5);

            $is_closed = in_array($current_day, $close_days) || 
                ($game->spl == 1 
                    ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                    : ($current_time > $close_time));

            if ($is_closed) {
                return redirect()->route('home');
            }
            else{
                if($current_time > $open_time && $request->game_type == 'open'){
                    return redirect()->route('home');
                }
                else{
                    $userid = Auth::id();
                    $game_type = $request->game_type;
                    $wallet = $this->wallet;
                    $game_no_arr = $request->game_no;

                    $points = 0;
                    foreach($game_no_arr as $row){
                        if(!empty($row) && $row >= 5){
                            $points += $row;
                        }
                    }
                    $current_balance = ($wallet - $points);

                    if($points > 0 && $points <= $wallet){
                        $payload = [
                            'category' => 'matka',
                            'game_id' => $gameid,
                            'game_mode' => 3,
                            'game_type' => $game_type,
                            'wallet_current_balance' => $current_balance,
                            'wallet_prev_balance' => $wallet,
                            'total_points' => $points,
                            'created_by' => $userid,
                        ];
                        $bids = Bids::create($payload);
                        $bidid = $bids->id;
                        
                        foreach($game_no_arr as $key => $value){
                            if(!empty($value) && $value >= 5){
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
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function double_pana($id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time = Carbon::parse($game->open_time)->subMinutes(5);
        $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
        $close_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->close_time)->subMinutes(5);

        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                : ($current_time > $close_time));

        if ($is_closed) {
            return redirect()->route('home');
        }
        else{
            return view('customer.mode.double_pana', compact('game', 'wallet', 'current_time', 'open_time', 'close_time'));
        }
    }

    public function double_pana_store(Request $request)
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

            $open_time = Carbon::parse($game->open_time)->subMinutes(5);
            $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
            $close_time = $game->spl == 1 
                ? Carbon::parse('00:00:00') 
                : Carbon::parse($game->close_time)->subMinutes(5);

            $is_closed = in_array($current_day, $close_days) || 
                ($game->spl == 1 
                    ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                    : ($current_time > $close_time));

            if ($is_closed) {
                return redirect()->route('home');
            }
            else{
                if($current_time > $open_time && $request->game_type == 'open'){
                    return redirect()->route('home');
                }
                else{
                    $userid = Auth::id();
                    $game_type = $request->game_type;
                    $wallet = $this->wallet;
                    $game_no_arr = $request->game_no;

                    $points = 0;
                    foreach($game_no_arr as $row){
                        if(!empty($row) && $row >= 5){
                            $points += $row;
                        }
                    }
                    $current_balance = ($wallet - $points);

                    if($points > 0 && $points <= $wallet){
                        $payload = [
                            'category' => 'matka',
                            'game_id' => $gameid,
                            'game_mode' => 4,
                            'game_type' => $game_type,
                            'wallet_current_balance' => $current_balance,
                            'wallet_prev_balance' => $wallet,
                            'total_points' => $points,
                            'created_by' => $userid,
                        ];
                        $bids = Bids::create($payload);
                        $bidid = $bids->id;
                        
                        foreach($game_no_arr as $key => $value){
                            if(!empty($value) && $value >= 5){
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
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function triple_pana($id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time = Carbon::parse($game->open_time)->subMinutes(5);
        $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
        $close_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->close_time)->subMinutes(5);

        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                : ($current_time > $close_time));

        if ($is_closed) {
            return redirect()->route('home');
        }
        else{
            return view('customer.mode.triple_pana', compact('game', 'wallet', 'current_time', 'open_time', 'close_time'));
        }
    }

    public function triple_pana_store(Request $request)
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

            $open_time = Carbon::parse($game->open_time)->subMinutes(5);
            $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
            $close_time = $game->spl == 1 
                ? Carbon::parse('00:00:00') 
                : Carbon::parse($game->close_time)->subMinutes(5);

            $is_closed = in_array($current_day, $close_days) || 
                ($game->spl == 1 
                    ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                    : ($current_time > $close_time));

            if ($is_closed) {
                return redirect()->route('home');
            }
            else{
                if($current_time > $open_time && $request->game_type == 'open'){
                    return redirect()->route('home');
                }
                else{
                    $userid = Auth::id();
                    $game_type = $request->game_type;
                    $wallet = $this->wallet;
                    $game_no_arr = $request->game_no;

                    $points = 0;
                    foreach($game_no_arr as $row){
                        if(!empty($row) && $row >= 5){
                            $points += $row;
                        }
                    }
                    $current_balance = ($wallet - $points);

                    if($points > 0 && $points <= $wallet){
                        $payload = [
                            'category' => 'matka',
                            'game_id' => $gameid,
                            'game_mode' => 5,
                            'game_type' => $game_type,
                            'wallet_current_balance' => $current_balance,
                            'wallet_prev_balance' => $wallet,
                            'total_points' => $points,
                            'created_by' => $userid,
                        ];
                        $bids = Bids::create($payload);
                        $bidid = $bids->id;
                        
                        foreach($game_no_arr as $key => $value){
                            if(!empty($value) && $value >= 5){
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
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }

    public function odd_even($id)
    {
        $game = GameMaster::find($id);
        $wallet = $this->wallet;
        $current_time = Carbon::now();
        $current_day = $current_time->format('l');        

        $close_days = json_decode($game->closing_days, true) ?? [];

        $open_time = Carbon::parse($game->open_time)->subMinutes(5);
        $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
        $close_time = $game->spl == 1 
            ? Carbon::parse('00:00:00') 
            : Carbon::parse($game->close_time)->subMinutes(5);

        $is_closed = in_array($current_day, $close_days) || 
            ($game->spl == 1 
                ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                : ($current_time > $close_time));

        if ($is_closed) {
            return redirect()->route('home');
        }
        else{
            return view('customer.mode.odd_even', compact('game', 'wallet', 'current_time', 'open_time', 'close_time'));
        }
    }

    public function odd_even_store(Request $request)
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

            $open_time = Carbon::parse($game->open_time)->subMinutes(5);
            $close_time_spl_game = Carbon::parse($game->close_time)->addHour();
            $close_time = $game->spl == 1 
                ? Carbon::parse('00:00:00') 
                : Carbon::parse($game->close_time)->subMinutes(5);

            $is_closed = in_array($current_day, $close_days) || 
                ($game->spl == 1 
                    ? ($current_time > $close_time && $current_time < $close_time_spl_game)
                    : ($current_time > $close_time));

            if ($is_closed) {
                return redirect()->route('home');
            }
            else{
                if($current_time > $open_time && $request->game_type == 'open'){
                    return redirect()->route('home');
                }
                else{
                    $userid = Auth::id();
                    $game_type = $request->game_type;
                    $wallet = $this->wallet;
                    $game_no_arr = $request->game_no;

                    $points = 0;
                    foreach($game_no_arr as $row){
                        if(!empty($row) && $row >= 5){
                            $points += $row;
                        }
                    }
                    $current_balance = ($wallet - $points);

                    if($points > 0 && $points <= $wallet){
                        $payload = [
                            'category' => 'matka',
                            'game_id' => $gameid,
                            'game_mode' => 6,
                            'game_type' => $game_type,
                            'wallet_current_balance' => $current_balance,
                            'wallet_prev_balance' => $wallet,
                            'total_points' => $points,
                            'created_by' => $userid,
                        ];
                        $bids = Bids::create($payload);
                        $bidid = $bids->id;
                        
                        foreach($game_no_arr as $key => $value){
                            if(!empty($value) && $value >= 5){
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
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }
}
