@extends('layouts.sidebar')

@section('title', 'Kelola Venue')

@section('content')
<div class="max-w-5xl mx-auto space-y-4">

    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-800">Daftar Venue</h2>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('venues.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                + Tambah Venue
            </a>
        @endif
    </div>

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-gray-500 uppercase text-[10px]">
                    <tr>
                        <th class="p-3">Nama Venue</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="p-3">Owner</th>
                        @endif
                        <th class="p-3">Alamat</th>
                        <th class="p-3">Jumlah Lapangan</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($venues as $venue)
                        <tr>
                            <td class="p-3 font-semibold text-gray-800">{{ $venue->name }}</td>
                            @if(auth()->user()->role === 'admin')
                                <td class="p-3">{{ $venue->owner->name ?? '-' }}</td>
                            @endif
                            <td class="p-3 text-gray-500">{{ \Illuminate\Support\Str::limit($venue->address, 40) }}</td>
                            <td class="p-3">{{ $venue->fields_count }}</td>
                            <td class="p-3 text-right space-x-2">
                                <a href="{{ route('venues.show', $venue->id) }}" class="text-gray-600 font-semibold hover:underline">Detail</a>
                                <a href="{{ route('venues.edit', $venue->id) }}" class="text-blue-600 font-semibold hover:underline">Edit</a>
                                <form action="{{ route('venues.destroy', $venue->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin mau hapus venue ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="p-4 text-center text-gray-400">Belum ada venue.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection