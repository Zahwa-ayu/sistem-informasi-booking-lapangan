@extends('layouts.sidebar')

@section('title', 'Tambah Venue')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl border shadow-sm">
    <h2 class="text-lg font-bold text-gray-800 mb-5">Tambah Venue Baru</h2>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 p-3 rounded-xl mb-4 text-xs">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('venues.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Owner</label>
            <select name="owner_id" class="w-full border p-2.5 rounded-lg text-xs">
                @foreach($owners as $owner)
                    <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                        {{ $owner->name }} ({{ $owner->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Venue</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2.5 rounded-lg text-xs">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat</label>
            <textarea name="address" rows="2" class="w-full border p-2.5 rounded-lg text-xs">{{ old('address') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi (opsional)</label>
            <textarea name="description" rows="3" class="w-full border p-2.5 rounded-lg text-xs">{{ old('description') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('venues.index') }}" class="flex-1 text-center border py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-xs font-bold transition">Simpan</button>
        </div>
    </form>
</div>
@endsection