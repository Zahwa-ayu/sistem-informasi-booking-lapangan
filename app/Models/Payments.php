<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model{
    protected $fillable = [
    'booking_id',
    'payment_method',
    'payment_status',
    'transaction_id',
    'paid_at'
   ];
}