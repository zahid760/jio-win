<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequests extends Model
{
    protected $fillable = ['amount', 'status', 'created_by', 'updated_by'];

    public function bankDetails(){
        return $this->hasOne(UserBankDetails::class, 'created_by', 'created_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
