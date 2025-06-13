<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    protected $fillable = ['category', 'game_id', 'game_mode', 'game_type', 'wallet_current_balance', 'wallet_prev_balance', 'total_points', 'created_by', 'updated_by'];

    public function bidchild(){
        return $this->hasMany(BidChild::class, 'bid_id')->orderBy('id', 'DESC');
    }

    public function gamemode(){
        return $this->belongsTo(GameMode::class, 'game_mode');
    }

    public function game(){
        return $this->belongsTo(GameMaster::class, 'game_id');
    }
}
