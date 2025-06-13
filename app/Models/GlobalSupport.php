<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSupport extends Model
{
    protected $fillable = ['whatsapp_no', 'telegram', 'instagram', 'call_no', 'created_by', 'updated_by'];
}
