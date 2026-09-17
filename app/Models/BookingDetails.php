<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetails extends Model{
    protected $fillable = [
    'booking_id',
    'field_id',
    'start_time',
    'end_time',
    'price'
   ];

    public function bookings()
    {
        return $this->belongsTo(Bookings::class, 'booking_id');
    }

   public function field(){
    return $this->belongsTo(Fields::class, 'field_id');
   }
}