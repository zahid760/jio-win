<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['user_id', 'winer_user_id', 'event_type', 'title', 'description', 'created_by', 'updated_by'];
}
