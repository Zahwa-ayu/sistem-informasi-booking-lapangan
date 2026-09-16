<?php

namespace App\Http\Controllers;

use App\Models\BookingDetails;
use App\Models\Fields;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(){
        $fields = Fields::with('venue')->latest()->get();

        return view('landing.index', compact('fields'));
    }

    public function show(Request $request, $id){
        $field = Fields::with('venue')->findOrFail($id);

        $selectedDate = $request->input('date', date('Y-m-d'));

        $bookedSlots = BookingDetails::where('field_id', $id)
        ->whereHas('bookings', function ($query) use ($selectedDate){
         $query->where('booking_date', $selectedDate)
         ->whereIn('status', ['paid', 'pending']);   
        })
        ->pluck('start_time')
        ->map(fn($time) => substr($time, 0,5)) // Format 'HH:MM'
        ->toArray();

        // daftar seluruh slot jam
        $operatingHours = [
            '08:00', '09:00', '10:00', '11:00', '12:00',
            '13:00', '14:00', '15:00', '16:00', '17:00',
            '18:00', '19:00', '20:00', '21:00'
        ];

        return view('landing.show', compact(
            'field', 'selectedDate', 'bookedSlots', 'operatingHours'
        ));
    }
}