<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model{
    protected $fillable = [
    'venue_id',
    'name',
    'type',
    'price_per_hour'
   ];

   public function venue(){
    return $this->belongsTo(Venues::class);
   }

   public function bookingDetails(){
    return $this->hasMany(BookingDetails::class);
   }
}