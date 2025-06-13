<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $fillable = ['user_id', 'bidchild_id', 'win_amount', 'created_by', 'updated_by'];
}
