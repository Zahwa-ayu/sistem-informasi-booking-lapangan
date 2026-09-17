<?php

namespace App\Http\Controllers;

use App\Models\Fields;
use App\Models\Venues;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function store(Request $request, Venues $venue)
    {
        if (auth()->user()->role !== 'admin' && $venue->owner_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'type'           => 'required|in:futsal,badminton,basket',
            'price_per_hour' => 'required|numeric|min:0',
        ]);

        $venue->fields()->create($request->only('name', 'type', 'price_per_hour'));

        return back()->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit(Fields $field)
    {
        $field->load('venue');

        if (auth()->user()->role !== 'admin' && $field->venue->owner_id !== auth()->id()) {
            abort(403);
        }

        return view('fields.edit', compact('field'));
    }

    public function update(Request $request, Fields $field)
    {
        $field->load('venue');

        if (auth()->user()->role !== 'admin' && $field->venue->owner_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'type'           => 'required|in:futsal,badminton,basket',
            'price_per_hour' => 'required|numeric|min:0',
        ]);

        $field->update($request->only('name', 'type', 'price_per_hour'));

        return redirect()->route('venues.show', $field->venue_id)->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Fields $field)
    {
        $field->load('venue');

        if (auth()->user()->role !== 'admin' && $field->venue->owner_id !== auth()->id()) {
            abort(403);
        }

        if ($field->bookingDetails()->exists()) {
            return back()->with('error', 'Lapangan tidak bisa dihapus karena masih punya riwayat booking.');
        }

        $venueId = $field->venue_id;
        $field->delete();

        return redirect()->route('venues.show', $venueId)->with('success', 'Lapangan berhasil dihapus.');
    }
}