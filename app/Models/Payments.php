<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model{
    protected $fillable = [
    'booking_id',
    'payment_method',
    'payments_status',
    'transaction_id',
    'paid_at'
   ];
public function payments(){
    return $this->hasOne(Bookings::class, 'booking_id');
}

   }