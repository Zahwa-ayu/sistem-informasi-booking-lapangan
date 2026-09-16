@extends('layouts.app')

@section('title', 'Konfirmasi Checkout - SiBook Lapangan')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        
        {{-- Card Utama --}}
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200/80">
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-1">Konfirmasi Pemesanan</h1>
            <p class="text-xs md:text-sm text-gray-500 mb-6">Periksa kembali rincian pemesanan kamu sebelum melanjutkan ke pembayaran.</p>

            <!-- Informasi Lapangan -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 mb-6 flex justify-between items-start gap-3">
                <div>
                    <span class="text-[10px] font-extrabold uppercase bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded tracking-wider">
                        {{ $field->type ?? 'Lapangan' }}
                    </span>
                    <h2 class="font-bold text-base text-gray-900 mt-2">{{ $field->name }}</h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        📍 {{ $field->venue->name ?? 'Venue' }} 
                        @if(isset($field->venue->address))
                            - {{ $field->venue->address }}
                        @endif
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-gray-400 uppercase font-semibold block">Tarif</span>
                    <span class="text-xs font-bold text-emerald-600">
                        Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="text-[10px] font-normal text-gray-400"> / jam</span>
                    </span>
                </div>
            </div>

            <!-- Detail Jadwal & Jam yang Dipilih -->
            <div class="space-y-3 text-xs md:text-sm text-gray-700 mb-8 border-t border-b border-gray-100 py-4">
                <div class="flex justify-between items-center py-1">
                    <span class="text-gray-500">Tanggal Main:</span>
                    <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($bookingDate)->isoFormat('D MMMM Y') }}</span>
                </div>
                
                <div class="flex justify-between items-start py-1">
                    <span class="text-gray-500 mt-1">Slot Jam Dipilih:</span>
                    <div class="flex flex-wrap gap-1 justify-end max-w-xs">
                        @foreach($selectedHours as $hour)
                            <span class="bg-blue-50 text-blue-700 border border-blue-200/60 font-semibold px-2.5 py-1 rounded-md text-xs">
                                {{ $hour }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between items-center py-1">
                    <span class="text-gray-500">Total Durasi:</span>
                    <span class="font-bold text-gray-900">{{ count($selectedHours) }} Jam</span>
                </div>

                <div class="flex justify-between items-center pt-3 border-t border-dashed border-gray-200 text-base font-bold">
                    <span class="text-gray-900">Total Pembayaran:</span>
                    <span class="text-emerald-600 text-lg">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Form untuk Mengirim Data ke Method store() -->
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <input type="hidden" name="field_id" value="{{ $field->id }}">
                <input type="hidden" name="booking_date" value="{{ $bookingDate }}">

                <!-- Mengirimkan Array Jam yang Dipilih -->
                @foreach($selectedHours as $hour)
                    <input type="hidden" name="selected_hours[]" value="{{ $hour }}">
                @endforeach

                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('landing.show', $field->id) }}" class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition py-2">
                        &larr; Batalkan & Pilih Ulang Jam
                    </a>
                    
                    <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl text-xs uppercase tracking-wider transition shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Konfirmasi & Buat Pesanan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection