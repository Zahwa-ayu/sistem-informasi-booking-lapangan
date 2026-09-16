@extends('layouts.app')

@section('title', $field->name . ' - Detail Booking')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Tombol Kembali --}}
        <div>
            <a href="{{ route('landing.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg transition border border-blue-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Katalog</span>
            </a>
        </div>

        {{-- Container Utama --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-6 md:p-8">
            
            {{-- Header Informasi Lapangan (Dinamis Sesuai DB) --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-100">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2">
                        <span class="text-[10px] font-extrabold uppercase bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-0.5 rounded-md tracking-wider">
                            {{ $field->type }}
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">{{ $field->name }}</h1>
                    <p class="text-gray-500 text-xs md:text-sm mt-1 flex items-center gap-1">
                        📍 {{ $field->venue->name ?? 'Venue Lapangan' }} 
                        @if(isset($field->venue->address))
                            — <span class="text-gray-400">{{ $field->venue->address }}</span>
                        @endif
                    </p>
                </div>
                
                <div class="bg-slate-50 border border-slate-200/80 p-3.5 rounded-xl text-left md:text-right">
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Harga Sewa</span>
                    <p class="text-emerald-600 font-extrabold text-xl leading-tight">
                        Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} <span class="text-xs text-gray-400 font-normal">/ jam</span>
                    </p>
                </div>
            </div>

            {{-- Form Pilih Tanggal --}}
            <div class="py-6 border-b border-gray-100">
                <form method="GET" action="{{ route('landing.show', $field->id) }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <label class="font-bold text-xs uppercase text-gray-500 tracking-wider">Pilih Tanggal Main:</label>
                    <div class="relative w-full sm:w-64">
                        <input type="date" name="date" value="{{ $selectedDate }}" onchange="this.form.submit()"
                               class="border border-gray-300 bg-gray-50/50 p-2.5 rounded-lg text-xs font-semibold text-gray-800 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none cursor-pointer transition">
                    </div>
                </form>
            </div>

            {{-- Form Slot Jam & Checkout --}}
            <div class="pt-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                    <h3 class="font-bold text-base text-gray-800">
                        Pilih Slot Jam Operasional <span class="text-blue-600">({{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }})</span>:
                    </h3>
                    
                    {{-- Legend / Status Slot --}}
                    <div class="flex items-center gap-3 text-[11px] text-gray-500">
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-emerald-500"></span> Tersedia</span>
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-amber-500"></span> Dipilih</span>
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-gray-300"></span> Booked</span>
                    </div>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="field_id" value="{{ $field->id }}">
                    <input type="hidden" name="booking_date" value="{{ $selectedDate }}">
                    <input type="hidden" id="selected-hours-input" name="selected_hours">

                    <!-- Grid Slot Jam -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 mb-8">
                        @foreach($operatingHours as $hour)
                            @php $isBooked = in_array($hour, $bookedSlots); @endphp

                            @if($isBooked)
                                <!-- Slot Terisi (Disabled) -->
                                <button type="button" disabled class="bg-gray-100 border border-gray-200 text-gray-400 font-semibold py-3 px-2 rounded-xl text-center cursor-not-allowed flex flex-col items-center justify-center gap-0.5">
                                    <span class="text-sm font-bold leading-none">{{ $hour }}</span>
                                    <span class="text-[10px] font-normal uppercase tracking-wider bg-gray-200 text-gray-500 px-1.5 py-0.5 rounded mt-1">Booked</span>
                                </button>
                            @else
                                <!-- Slot Tersedia -->
                                <button type="button"
                                        onclick="toggleSlot(this, '{{ $hour }}')"
                                        class="slot-btn bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-2 rounded-xl text-center transition shadow-sm hover:shadow flex flex-col items-center justify-center gap-0.5">
                                    <span class="text-sm font-bold leading-none">{{ $hour }}</span>
                                    <span class="text-[10px] font-medium opacity-90">Tersedia</span>
                                </button>
                            @endif
                        @endforeach
                    </div>

                    <!-- Info Ringkasan & Tombol Submit -->
                    <div class="border-t border-gray-200 pt-6 bg-slate-50 -mx-6 -mb-6 md:-mx-8 md:-mb-8 p-6 md:p-8 rounded-b-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="space-y-1">
                            <p class="text-xs text-gray-500">
                                Jam Dipilih: <span id="display-hours" class="font-bold text-gray-800 text-sm">-</span>
                            </p>
                            <p class="text-xs text-gray-500">
                                Total Biaya: <span id="display-total" class="font-extrabold text-emerald-600 text-lg ml-1">Rp 0</span>
                            </p>
                        </div>
                        
                        <button type="submit" id="btn-submit" disabled class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl text-xs uppercase tracking-wider opacity-50 cursor-not-allowed transition shadow-sm flex items-center justify-center gap-2">
                            <span>Lanjut ke Checkout</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    let selectedHours = [];
    const pricePerHour = {{ $field->price_per_hour }};

    function toggleSlot(button, hour) {
        if (selectedHours.includes(hour)) {
            selectedHours = selectedHours.filter(h => h !== hour);
            button.classList.remove('bg-amber-500', 'hover:bg-amber-600');
            button.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
        } else {
            selectedHours.push(hour);
            button.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
            button.classList.add('bg-amber-500', 'hover:bg-amber-600');
        }

        selectedHours.sort();

        document.getElementById('selected-hours-input').value = JSON.stringify(selectedHours);
        document.getElementById('display-hours').innerText = selectedHours.length > 0 ? selectedHours.join(', ') : '-';

        const total = selectedHours.length * pricePerHour;
        document.getElementById('display-total').innerText = 'Rp ' + total.toLocaleString('id-ID');

        const submitBtn = document.getElementById('btn-submit');
        if (selectedHours.length > 0) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }
</script>
@endpush