<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Simulator Pembayaran - {{ $booking->booking_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md border">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h1 class="text-xl font-bold">Simulator Pembayaran</h1>
            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $booking->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ strtoupper($booking->status) }}
            </span>
        </div>

        <!-- Detail Ringkasan Booking -->
        <div class="mb-6 text-sm text-gray-700 space-y-1">
            <p><strong>Kode Booking:</strong> {{ $booking->booking_code }}</p>
            <p><strong>Tanggal Main:</strong> {{ $booking->booking_date }}</p>
            <p><strong>Total Bayar:</strong> <span class="text-green-600 font-bold text-lg">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></p>
        </div>

        @if($booking->status === 'pending')
            <!-- Form Simulasi Bayar -->
            <form action="{{ route('payment.simulate', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Pilih Metode Pembayaran Simulasi:</label>
                    <select name="payment_method" class="w-full border p-2 rounded">
                        <option value="bca_va">BCA Virtual Account (Simulasi)</option>
                        <option value="qris">QRIS (Simulasi)</option>
                        <option value="mandiri_va">Mandiri Virtual Account (Simulasi)</option>
                    </select>
                </div>

                <div class="p-3 bg-blue-50 text-blue-700 text-xs rounded mb-4">
                    💡 Ini adalah tombol simulasi. Mengklik tombol di bawah akan mensimulasikan sistem *Webhook* dari Payment Gateway untuk menguba status transaksi dari <strong>PENDING</strong> menjadi <strong>PAID</strong>.
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded transition">
                    Simulasikan Bayar Lunas Sekarang
                </button>
            </form>
        @else
            <!-- Tampilan Jika Sudah Lunas -->
<div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded text-center">
    <p class="font-bold">Pembayaran Telah Selesai!</p>
    <p class="text-xs mt-1">Metode: {{ $booking->payment->payment_method ?? '-' }}</p>
    <p class="text-xs mt-1">Dibayar pada: {{ $booking->payment->paid_at ?? '-' }}</p>
</div>
            <a href="{{ route('landing.index') }}" class="block text-center text-blue-600 text-sm mt-4 hover:underline">
                &larr; Kembali ke Katalog
            </a>
        @endif
    </div>
</body>
</html>