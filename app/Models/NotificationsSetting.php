<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationsSetting extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['user_id', 'matka_game', 'satta_game', 'status', 'created_by', 'updated_by'];
}
