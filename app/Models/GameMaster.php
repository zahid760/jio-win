<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class GameMaster extends Model
{
    use SoftDeletes;

    protected $fillable = ['category', 'name', 'priority', 'open_time', 'close_time', 'spl', 'closing_days', 'created_by', 'updated_by'];

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    //result for home
    public function result(){
        return $this->hasOne(GameResult::class, 'game_id')->whereDate('result_date', Carbon::today());
    }

    //result for game result history
    public function game_result_history(){
        return $this->hasOne(GameResult::class, 'game_id');
    }

    //result for home special game
    public function result_spl(){
        return $this->hasOne(GameResult::class, 'game_id')->whereDate('result_date', Carbon::today()->subDay());
    }
}
