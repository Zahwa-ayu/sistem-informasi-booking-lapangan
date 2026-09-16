@extends('layouts.app')

@section('title', 'Katalog Lapangan - FitCourt')

@section('content')
    {{-- Banner Hero (Versi Netral & General) --}}
    <div class="relative rounded-2xl mb-8 overflow-hidden shadow-2xl border border-blue-900/40">
        {{-- Background Image --}}
        <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=1600&auto=format&fit=crop" 
             alt="Lapangan FitCourt" 
             class="absolute inset-0 w-full h-full object-cover object-center transform scale-105 filter brightness-90">

        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-blue-950/80 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

        <div class="relative z-10 p-6 md:p-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-blue-500/20 backdrop-blur-md text-blue-300 text-xs px-3.5 py-1.5 rounded-full mb-4 border border-blue-500/30 font-medium">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                <span>Pemesanan Lapangan Olahraga Online</span>
            </div>
            
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3 leading-tight tracking-tight drop-shadow-md">
                Booking Lapangan Olahraga <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-sky-300">Mudah & Cepat</span>
            </h1>
            
            <p class="text-slate-200 text-xs md:text-sm mb-6 leading-relaxed max-w-xl drop-shadow">
                Temukan dan sewa berbagai pilihan lapangan futsal, badminton, dan basket dari berbagai venue terdekat dengan harga terbaik.
            </p>

            {{-- Form Filter Pencarian --}}
            <form action="{{ route('landing.index') }}" method="GET" class="bg-white/95 backdrop-blur-md p-3 rounded-2xl text-gray-800 shadow-2xl border border-white/20 grid grid-cols-1 sm:grid-cols-3 md:grid-cols-7 gap-2 items-center">
                <div class="sm:col-span-1 md:col-span-3 px-3 py-1 border-b sm:border-b-0 sm:border-r border-gray-200">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Kategori Olahraga</label>
                    <select name="type" class="w-full text-xs font-bold text-gray-800 focus:outline-none bg-transparent cursor-pointer py-1">
                        <option value="">Semua Olahraga</option>
                        <option value="futsal" {{ request('type') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                        <option value="badminton" {{ request('type') == 'badminton' ? 'selected' : '' }}>Badminton</option>
                        <option value="basket" {{ request('type') == 'basket' ? 'selected' : '' }}>Basket</option>
                    </select>
                </div>

                <div class="sm:col-span-1 md:col-span-3 px-3 py-1 border-b sm:border-b-0 sm:border-r border-gray-200">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Tanggal Sewa</label>
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="w-full text-xs font-bold text-gray-800 focus:outline-none bg-transparent cursor-pointer py-1">
                </div>

                <div class="sm:col-span-1 md:col-span-1 mt-2 sm:mt-0">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-3 rounded-xl text-xs flex items-center justify-center gap-1.5 transition duration-300 shadow-md shadow-blue-600/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cari</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Layout Utama: Grid Lapangan Utama --}}
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Daftar Lapangan Olahraga</h2>
                <p class="text-xs text-gray-500">Pilih lapangan dan cek ketersediaan jadwal</p>
            </div>
        </div>

        {{-- Grid Kartu Lapangan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($fields as $field)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-5 flex flex-col justify-between hover:shadow-lg hover:border-blue-500/40 transition duration-300">
                    <div>
                        {{-- Header Card --}}
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-[10px] font-extrabold uppercase bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-md tracking-wider">
                                {{ $field->type }}
                            </span>
                            <span class="text-[10px] text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-1 rounded-full flex items-center gap-1 border border-emerald-200">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Aktif
                            </span>
                        </div>

                        {{-- Nama Lapangan & Venue --}}
                        <h3 class="text-lg font-bold text-gray-900 leading-snug mb-1">{{ $field->name }}</h3>
                        
                        <p class="text-gray-500 text-xs mb-4 flex items-center gap-1 font-medium">
                            📍 {{ $field->venue->name ?? 'Venue Lapangan' }}
                        </p>

                        @if(isset($field->venue->address))
                            <p class="text-gray-400 text-[11px] mb-4 line-clamp-1">
                                {{ $field->venue->address }}
                            </p>
                        @endif
                    </div>

                    <div>
                        {{-- Harga Sewa --}}
                        <div class="mb-4 pt-3 border-t border-gray-100">
                            <span class="text-[10px] text-gray-400 block uppercase tracking-wider font-semibold">Harga Sewa</span>
                            <p class="text-blue-600 font-extrabold text-lg leading-none">
                                Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} <span class="text-xs text-gray-400 font-normal">/ jam</span>
                            </p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <a href="{{ route('landing.show', $field->id) }}"
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-xs transition shadow-sm flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Lihat Jadwal & Sewa</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
                    <p class="text-gray-500 text-sm font-medium">Belum ada lapangan yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection