<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    protected $fillable = ['transaction_id', 'amount', 'comment', 'reciept_photo', 'status', 'created_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
