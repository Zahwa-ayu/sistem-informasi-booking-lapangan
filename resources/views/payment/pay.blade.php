@extends('layouts.app')

@section('title', 'Pembayaran - ' . $booking->booking_code)

@push('head')
    @if($snapToken)
        <script
            src="{{ $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ $clientKey }}"></script>
    @endif
@endpush

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md border">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h1 class="text-xl font-bold">Pembayaran</h1>
            <span class="text-xs font-bold px-3 py-1 rounded-full
                @if($booking->status === 'paid') bg-green-100 text-green-800
                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800 @endif">
                {{ strtoupper($booking->status) }}
            </span>
        </div>

        <!-- Ringkasan Booking -->
        <div class="mb-6 text-sm text-gray-700 space-y-1">
            <p><strong>Kode Booking:</strong> {{ $booking->booking_code }}</p>
            <p><strong>Tanggal Main:</strong> {{ $booking->booking_date }}</p>
            <p><strong>Total Bayar:</strong>
                <span class="text-green-600 font-bold text-lg">
                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                </span>
            </p>
        </div>

        @if($booking->status === 'pending')
            @if($snapToken)
                <button id="pay-button"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded transition">
                    Bayar Sekarang
                </button>
            @else
                <div class="p-3 bg-red-50 text-red-700 text-xs rounded mb-2">
                    Tidak bisa membuat transaksi Midtrans saat ini. Pastikan
                    <code>MIDTRANS_SERVER_KEY</code> sudah diisi di file <code>.env</code>,
                    lalu muat ulang halaman ini.
                </div>
            @endif

            <form id="check-status-form"
                  action="{{ route('payment.check-status', $booking->id) }}"
                  method="POST" class="mt-3">
                @csrf
                <button type="submit"
                        class="w-full border border-gray-300 text-gray-600 text-sm py-2 rounded hover:bg-gray-50">
                    Sudah bayar? Cek status pembayaran
                </button>
            </form>

            <p class="text-xs text-gray-400 mt-3">
                💡 Setelah membayar lewat popup Midtrans, status akan otomatis
                diperbarui lewat notifikasi (webhook) dari Midtrans. Kalau kamu
                menjalankan aplikasi ini di localhost, webhook itu tidak akan
                sampai kecuali lewat tunnel (ngrok/expose) — jadi pakai tombol
                "Cek status pembayaran" di atas untuk menyinkronkan status secara manual.
            </p>
        @elseif($booking->status === 'paid')
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded text-center">
                <p class="font-bold">Pembayaran Telah Selesai!</p>
                <p class="text-xs mt-1">Metode: {{ $booking->payment->payment_type ?? '-' }}</p>
                <p class="text-xs mt-1">ID Transaksi: {{ $booking->payment->transaction_id ?? '-' }}</p>
            </div>
            <a href="{{ route('landing.index') }}"
               class="block text-center text-blue-600 text-sm mt-4 hover:underline">
                &larr; Kembali ke Katalog
            </a>
        @else
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded text-center">
                <p class="font-bold">Pembayaran Gagal / Dibatalkan</p>
                <p class="text-xs mt-1">Slot jam pada booking ini sudah dilepas kembali.</p>
            </div>
            <a href="{{ route('landing.index') }}"
               class="block text-center text-blue-600 text-sm mt-4 hover:underline">
                &larr; Kembali ke Katalog
            </a>
        @endif
    </div>
@endsection

@if($snapToken)
    @push('scripts')
    <script>
        document.getElementById('pay-button')?.addEventListener('click', function () {
            snap.pay(@json($snapToken), {
                onSuccess: function () {
                    document.getElementById('check-status-form').submit();
                },
                onPending: function () {
                    document.getElementById('check-status-form').submit();
                },
                onError: function () {
                    alert('Pembayaran gagal diproses. Silakan coba lagi.');
                },
                onClose: function () {
                    // User menutup popup tanpa menyelesaikan pembayaran.
                    // Biarkan saja di halaman ini, tidak perlu tindakan otomatis.
                }
            });
        });
    </script>
    @endpush
@endif