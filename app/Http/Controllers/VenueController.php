<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venues;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        $venues = auth()->user()->role === 'admin'
            ? Venues::with('owner')->withCount('fields')->latest()->get()
            : Venues::where('owner_id', auth()->id())->withCount('fields')->latest()->get();

        return view('venues.index', compact('venues'));
    }

    public function create()
    {
        $owners = User::whereIn('role', ['owner', 'admin'])->get();

        return view('venues.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_id'    => 'required|exists:users,id',
            'name'        => 'required|string|max:255',
            'address'     => 'required|string',
            'description' => 'nullable|string',
        ]);

        Venues::create($request->only('owner_id', 'name', 'address', 'description'));

        return redirect()->route('venues.index')->with('success', 'Venue berhasil ditambahkan.');
    }

    public function show(Venues $venue)
    {
    if (auth()->user()->role !== 'admin' && $venue->owner_id !== auth()->id()) {
        abort(403);
    }

    $venue->load('owner', 'fields');

    return view('venues.show', compact('venue'));
    }

    public function edit(Venues $venue)
    {
        if (auth()->user()->role !== 'admin' && $venue->owner_id !== auth()->id()) {
            abort(403);
        }

        return view('venues.edit', compact('venue'));
    }

    public function update(Request $request, Venues $venue)
    {
        if (auth()->user()->role !== 'admin' && $venue->owner_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required|string',
            'description' => 'nullable|string',
        ]);

        $venue->update($request->only('name', 'address', 'description'));

        return redirect()->route('venues.index')->with('success', 'Venue berhasil diperbarui.');
    }

    public function destroy(Venues $venue)
    {
        if (auth()->user()->role !== 'admin' && $venue->owner_id !== auth()->id()) {
            abort(403);
        }

        if ($venue->fields()->exists()) {
            return back()->with('error', 'Venue tidak bisa dihapus karena masih punya lapangan terdaftar.');
        }

        $venue->delete();

        return redirect()->route('venues.index')->with('success', 'Venue berhasil dihapus.');
    }
}