@extends('layouts.sidebar')

@section('title', 'Edit Lapangan')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl border shadow-sm">
    <h2 class="text-lg font-bold text-gray-800 mb-5">Edit Lapangan</h2>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 p-3 rounded-xl mb-4 text-xs">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('fields.update', $field->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lapangan</label>
            <input type="text" name="name" value="{{ old('name', $field->name) }}" class="w-full border p-2.5 rounded-lg text-xs">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Tipe</label>
            <select name="type" class="w-full border p-2.5 rounded-lg text-xs">
                <option value="futsal" {{ old('type', $field->type) === 'futsal' ? 'selected' : '' }}>Futsal</option>
                <option value="badminton" {{ old('type', $field->type) === 'badminton' ? 'selected' : '' }}>Badminton</option>
                <option value="basket" {{ old('type', $field->type) === 'basket' ? 'selected' : '' }}>Basket</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Harga per Jam</label>
            <input type="number" name="price_per_hour" value="{{ old('price_per_hour', $field->price_per_hour) }}" min="0"
                   class="w-full border p-2.5 rounded-lg text-xs">
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('venues.show', $field->venue_id) }}" class="flex-1 text-center border py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-xs font-bold transition">Simpan</button>
        </div>
    </form>
</div>
@endsection