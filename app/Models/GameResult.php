<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    protected $fillable = ['game_id', 'open', 'jodi', 'close', 'result_date', 'created_by', 'updated_by'];
}
