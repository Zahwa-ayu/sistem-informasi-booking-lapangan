@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-semibold">Total Revenue</p>
            <p class="text-xl font-extrabold text-emerald-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-semibold">Total Booking</p>
            <p class="text-xl font-extrabold text-gray-900 mt-1">{{ $totalBookings }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-semibold">Booking Hari Ini</p>
            <p class="text-xl font-extrabold text-blue-600 mt-1">{{ $bookingsToday }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-semibold">Pembayaran Pending</p>
            <p class="text-xl font-extrabold text-amber-600 mt-1">{{ $pendingPayments }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-semibold">Total Venue</p>
            <p class="text-xl font-extrabold text-gray-900 mt-1">{{ $totalVenues }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-semibold">Total Lapangan</p>
            <p class="text-xl font-extrabold text-gray-900 mt-1">{{ $totalFields }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-semibold">Total Customer</p>
            <p class="text-xl font-extrabold text-gray-900 mt-1">{{ $totalCustomers }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-semibold">Status Booking</p>
            <div class="text-[11px] mt-1 space-y-0.5">
                @foreach($bookingsByStatus as $status => $total)
                    <div class="flex justify-between">
                        <span class="capitalize text-gray-500">{{ $status }}</span>
                        <span class="font-bold text-gray-800">{{ $total }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="p-4 border-b">
            <h2 class="font-bold text-sm text-gray-800">Booking Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-gray-500 uppercase text-[10px]">
                    <tr>
                        <th class="p-3">Kode</th>
                        <th class="p-3">Customer</th>
                        <th class="p-3">Lapangan</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td class="p-3 font-semibold text-gray-800">{{ $booking->booking_code }}</td>
                            <td class="p-3">{{ $booking->user->name ?? '-' }}</td>
                            <td class="p-3">{{ $booking->details->first()?->field->name ?? '-' }}</td>
                            <td class="p-3">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                            <td class="p-3 font-bold text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                    @if($booking->status === 'paid') bg-green-100 text-green-700
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-4 text-center text-gray-400">Belum ada booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Fields --}}
    <div class="bg-white rounded-xl border shadow-sm p-4">
        <h2 class="font-bold text-sm text-gray-800 mb-3">Lapangan Paling Sering Dipesan</h2>
        <div class="space-y-2">
            @forelse($topFields as $field)
                <div class="flex justify-between items-center text-xs border-b pb-2 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $field->name }}</p>
                        <p class="text-gray-400 text-[11px]">{{ $field->venue->name ?? '-' }}</p>
                    </div>
                    <span class="font-bold text-blue-600">{{ $field->bookings_count }} slot dipesan</span>
                </div>
            @empty
                <p class="text-gray-400 text-xs">Belum ada data.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection