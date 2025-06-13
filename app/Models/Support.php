<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = ['whatsapp_no', 'call_no', 'created_by', 'updated_by'];
}
