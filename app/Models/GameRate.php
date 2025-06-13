<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameRate extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['category', 'gamemode', 'bidding_rate', 'winning_rate', 'rate', 'created_by', 'updated_by'];

    public function game_mode(){
        return $this->belongsTo(GameMode::class, 'gamemode');
    }
}
