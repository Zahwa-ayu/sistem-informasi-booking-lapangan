<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $field->name }} - Detail Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
        <a href="{{ route('landing.index') }}" class="text-blue-600 text-sm mb-4 inline-block">&larr; Kembali ke Katalog</a>
        
        <h1 class="text-2xl font-bold">{{ $field->name }}</h1>
        <p class="text-gray-600">{{ $field->venue->name }} - {{ $field->venue->address }}</p>
        <p class="text-green-600 font-semibold text-lg mt-1">
            Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam
        </p>

        <hr class="my-6">

        <!-- Form Pilih Tanggal -->
        <form method="GET" action="{{ route('landing.show', $field->id) }}" class="mb-6">
            <label class="block font-medium mb-2">Pilih Tanggal Main:</label>
            <input type="date" name="date" value="{{ $selectedDate }}" onchange="this.form.submit()" 
                   class="border p-2 rounded w-full md:w-1/3">
        </form>

        <!-- Slot Jam Pemesanan (Model Bioskop) -->
        <h3 class="font-bold text-lg mb-3">Pilih Slot Jam Operasional ({{ $selectedDate }}):</h3>
        <form action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <!-- Input hidden untuk menyimpan ID lapangan, tanggal, dan array jam yang dipilih -->
    <input type="hidden" name="field_id" value="{{ $field->id }}">
    <input type="hidden" name="booking_date" value="{{ $selectedDate }}">
    <input type="hidden" id="selected-hours-input" name="selected_hours[]">

    <!-- Grid Slot Jam -->
    <div class="grid grid-cols-3 md:grid-cols-5 gap-3 mb-6">
        @foreach($operatingHours as $hour)
            @php $isBooked = in_array($hour, $bookedSlots); @endphp

            @if($isBooked)
                <!-- Slot Terisi (Disabled) -->
                <button type="button" disabled class="bg-gray-300 text-gray-500 font-semibold py-3 rounded text-center cursor-not-allowed">
                    {{ $hour }} <br> <span class="text-xs font-normal">Booked</span>
                </button>
            @else
                <!-- Slot Tersedia -->
                <button type="button" 
                        onclick="toggleSlot(this, '{{ $hour }}')" 
                        class="slot-btn bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 rounded text-center transition">
                    {{ $hour }} <br> <span class="text-xs font-normal">Tersedia</span>
                </button>
            @endif
        @endforeach
    </div>

    <!-- Info Ringkasan & Tombol Submit -->
    <div class="border-t pt-4 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-600">Jam Dipilih: <span id="display-hours" class="font-bold text-gray-800">-</span></p>
            <p class="text-sm text-gray-600">Total Biaya: <span id="display-total" class="font-bold text-green-600">Rp 0</span></p>
        </div>
        <button type="submit" id="btn-submit" disabled class="bg-blue-600 text-white font-bold py-2 px-6 rounded opacity-50 cursor-not-allowed">
            Lanjut ke Checkout
        </button>
    </div>
</form>

<!-- JavaScript Sederhana Tanpa Framework -->
<script>
    let selectedHours = [];
    const pricePerHour = {{ $field->price_per_hour }};

    function toggleSlot(button, hour) {
        if (selectedHours.includes(hour)) {
            // Jika jam sudah dipilih sebelumnya -> Hapus dari array (Unselect)
            selectedHours = selectedHours.filter(h => h !== hour);
            button.classList.remove('bg-amber-500', 'hover:bg-amber-600');
            button.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
        } else {
            // Jika jam belum dipilih -> Tambahkan ke array (Select)
            selectedHours.push(hour);
            button.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
            button.classList.add('bg-amber-500', 'hover:bg-amber-600');
        }

        // Urutkan jam agar rapi
        selectedHours.sort();

        // Update Input Hidden & Tampilan UI
        document.getElementById('selected-hours-input').value = JSON.stringify(selectedHours);
        document.getElementById('display-hours').innerText = selectedHours.length > 0 ? selectedHours.join(', ') : '-';
        
        // Kalkulasi Total Biaya
        const total = selectedHours.length * pricePerHour;
        document.getElementById('display-total').innerText = 'Rp ' + total.toLocaleString('id-ID');

        // Enable/Disable Tombol Submit
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
    </div>
</body>
</html>