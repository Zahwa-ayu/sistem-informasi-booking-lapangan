<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model{
    protected $fillable = [
    'booking_code',
    'user_id',
    'booking_date',
    'total_price',
    'status'
   ];

   public function user(){
    return $this->belongsTo(User::class);
   }

   public function details(){
    return $this->hasMany(BookingDetails::class);
   }

   public function payments(){
    return $this->hasOne(Payments::class);
   }
}