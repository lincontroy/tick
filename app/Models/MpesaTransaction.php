<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_request_id',
        'checkout_request_id',
        'result_desc',
        'result_code',
        'amount',
        'mpesa_receipt_number',
        'transaction_date',
        'phone_number'
    ];
}