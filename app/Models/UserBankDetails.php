<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBankDetails extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'account_number', 'ifsc', 'bank_name', 'upi_id', 'created_by', 'updated_by'];
}
