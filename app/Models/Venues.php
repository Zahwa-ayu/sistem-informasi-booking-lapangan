<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venues extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'address',
        'description',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function fields()
    {
        return $this->hasMany(Fields::class, 'venue_id');
    }
}