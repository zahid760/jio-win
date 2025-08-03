<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passbook extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'bid_id',
        'game_number',
        'points',
        'prev_balance',
        'current_balance',
        'winner_id',
        'status',
        'created_by',
        'updated_by',
    ];

    public function bid(){
        return $this->belongsTo(Bids::class, 'bid_id');
    }

    public function winner(){
        return $this->belongsTo(Winner::class, 'winner_id');
    }
}
