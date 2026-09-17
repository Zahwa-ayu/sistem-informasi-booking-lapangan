@extends('layouts.sidebar')

@section('title', 'Edit Venue')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl border shadow-sm">
    <h2 class="text-lg font-bold text-gray-800 mb-5">Edit Venue</h2>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 p-3 rounded-xl mb-4 text-xs">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('venues.update', $venue->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Venue</label>
            <input type="text" name="name" value="{{ old('name', $venue->name) }}" class="w-full border p-2.5 rounded-lg text-xs">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat</label>
            <textarea name="address" rows="2" class="w-full border p-2.5 rounded-lg text-xs">{{ old('address', $venue->address) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi (opsional)</label>
            <textarea name="description" rows="3" class="w-full border p-2.5 rounded-lg text-xs">{{ old('description', $venue->description) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('venues.index') }}" class="flex-1 text-center border py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-xs font-bold transition">Simpan</button>
        </div>
    </form>
</div>
@endsection