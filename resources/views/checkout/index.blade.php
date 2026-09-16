<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Checkout - SiBook Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <!-- Tambahkan ini di paling atas bagian card -->
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
        {{ session('error') }}
    </div>
@endif
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md border">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Konfirmasi Pemesanan</h1>
        <p class="text-sm text-gray-600 mb-6">Periksa kembali rincian pemesanan kamu sebelum melanjutkan ke pembayaran.</p>

        <!-- Informasi Lapangan -->
        <div class="bg-gray-50 p-4 rounded-lg border mb-6">
            <h2 class="font-bold text-lg text-gray-800">{{ $field->name }}</h2>
            <p class="text-sm text-gray-600">📍 {{ $field->venue->name }} - {{ $field->venue->address }}</p>
            <p class="text-sm text-green-600 font-semibold mt-1">
                Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam
            </p>
        </div>

        <!-- Detail Jadwal & Jam yang Dipilih -->
        <div class="mb-6 space-y-2 text-sm text-gray-700">
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Tanggal Main:</span>
                <span class="font-bold">{{ \Carbon\Carbon::parse($bookingDate)->isoFormat('D MMMM Y') }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Slot Jam Dipilih:</span>
                <span class="font-bold text-blue-600">
                    @foreach($selectedHours as $hour)
                        <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs mr-1">{{ $hour }}</span>
                    @endforeach
                </span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Total Durasi:</span>
                <span class="font-bold">{{ count($selectedHours) }} Jam</span>
            </div>
            <div class="flex justify-between pt-2 text-base font-bold">
                <span>Total Pembayaran:</span>
                <span class="text-green-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
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

            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('landing.show', $field->id) }}" class="text-sm text-gray-500 hover:underline">
                    &larr; Batalkan & Pilih Ulang Jam
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-lg transition">
                    Konfirmasi & Buat Pesanan
                </button>
            </div>
        </form>
    </div>
</body>
</html>