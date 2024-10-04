<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'date',
        'gateway_reference_id',
        'status',
        'payment_gateway',
        'currancy_code',
        'amount',
    ];
    protected $casts = [
        'data' => 'json'
    ];
}
