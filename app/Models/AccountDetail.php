<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountDetail extends Model
{
    protected $fillable = ['account_number', 'account_holder', 'bank_name', 'ifsc', 'qr_image', 'qr_upi', 'upi', 'upi_account_holder', 'upi_bank_name', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}
