@extends('layouts.sidebar')

@section('title', 'Detail Venue')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('venues.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg transition border border-blue-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Venue</span>
        </a>
        <a href="{{ route('venues.edit', $venue->id) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
            Edit Venue
        </a>
    </div>

    {{-- Informasi Owner --}}
    <div class="bg-white rounded-xl border shadow-sm p-5">
        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Informasi Owner</h2>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                {{ strtoupper(substr($venue->owner->name ?? '-', 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $venue->owner->name ?? '-' }}</p>
                <p class="text-gray-400 text-xs">{{ $venue->owner->email ?? '-' }}</p>
                @if($venue->owner?->phone)
                    <p class="text-gray-400 text-xs">{{ $venue->owner->phone }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Informasi Venue --}}
    <div class="bg-white rounded-xl border shadow-sm p-5">
        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Informasi Venue</h2>
        <h1 class="text-xl font-extrabold text-gray-900">{{ $venue->name }}</h1>
        <p class="text-gray-500 text-xs mt-1">📍 {{ $venue->address }}</p>
        @if($venue->description)
            <p class="text-gray-600 text-sm mt-3 leading-relaxed">{{ $venue->description }}</p>
        @endif
    </div>

    {{-- Daftar Lapangan --}}
    {{-- Daftar Lapangan --}}
<div class="bg-white rounded-xl border shadow-sm overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
        <h2 class="font-bold text-sm text-gray-800">Daftar Lapangan ({{ $venue->fields->count() }})</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left">
            <thead class="bg-slate-50 text-gray-500 uppercase text-[10px]">
                <tr>
                    <th class="p-3">Nama Lapangan</th>
                    <th class="p-3">Tipe</th>
                    <th class="p-3">Harga / Jam</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($venue->fields as $field)
                    <tr>
                        <td class="p-3 font-semibold text-gray-800">{{ $field->name }}</td>
                        <td class="p-3">
                            <span class="text-[10px] font-extrabold uppercase bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded">
                                {{ $field->type }}
                            </span>
                        </td>
                        <td class="p-3 font-bold text-emerald-600">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('fields.edit', $field->id) }}" class="text-blue-600 font-semibold hover:underline">Edit</a>
                            <form action="{{ route('fields.destroy', $field->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin mau hapus lapangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-semibold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-4 text-center text-gray-400">Belum ada lapangan di venue ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Form Tambah Lapangan --}}
    <div class="p-4 bg-slate-50 border-t">
        <h3 class="text-xs font-bold text-gray-600 mb-3">+ Tambah Lapangan Baru</h3>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-2.5 rounded-lg mb-3 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('fields.store', $venue->id) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
            @csrf
            <input type="text" name="name" placeholder="Nama lapangan (mis. Lapangan A)" required
                   class="flex-1 border p-2.5 rounded-lg text-xs">

            <select name="type" required class="border p-2.5 rounded-lg text-xs">
                <option value="">Tipe</option>
                <option value="futsal">Futsal</option>
                <option value="badminton">Badminton</option>
                <option value="basket">Basket</option>
            </select>

            <input type="number" name="price_per_hour" placeholder="Harga/jam" required min="0"
                   class="w-32 border p-2.5 rounded-lg text-xs">

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2.5 rounded-lg text-xs transition">
                Tambah
            </button>
        </form>
    </div>
</div>
    </div>

</div>
@endsection