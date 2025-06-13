<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMode extends Model
{
    public function matka_game_rate(){
        return $this->belongsTo(GameRate::class, 'gamemode')->where('category', 'matka');
    }
}
