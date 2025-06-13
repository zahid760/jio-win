<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidChild extends Model
{
    protected $table = 'bid_childs';
    
    protected $fillable = ['bid_id', 'game_number', 'points', 'prev_balance', 'current_balance', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function winner(){
        return $this->hasOne(Winner::class, 'bidchild_id');
    }
}
