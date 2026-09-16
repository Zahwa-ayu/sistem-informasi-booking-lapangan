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

//    public function booking(){
//     return $this->belongsTo(Bookings::class);
//    }

    public function bookings()
    {
        return $this->belongsTo(Bookings::class, 'booking_id');
        // Catatan: Jika nama model utamamu adalah 'Bookings' (jamak), ganti menjadi Booking::class -> Bookings::class
    }

   public function fields(){
    return $this->hasMany(Fields::class);
   }
}