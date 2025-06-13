<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankDetails extends Model
{
    protected $fillable = ['name', 'account_number', 'ifsc', 'bank_name', 'upi_id', 'created_by', 'updated_by'];
}
