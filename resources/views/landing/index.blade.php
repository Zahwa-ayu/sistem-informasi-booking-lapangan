<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Lapangan - SiBook Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Daftar Lapangan Olahraga</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($fields as $field)
                <div class="bg-white rounded-lg shadow-md p-5 border">
                    <span class="text-xs font-bold uppercase bg-blue-100 text-blue-800 px-2 py-1 rounded">
                        {{ $field->type }}
                    </span>
                    <h2 class="text-xl font-bold mt-2">{{ $field->name }}</h2>
                    <p class="text-gray-600 text-sm mb-2">📍 {{ $field->venue->name }}</p>
                    <p class="text-green-600 font-semibold mb-4">
                        Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam
                    </p>
                    <a href="{{ route('landing.show', $field->id) }}" 
                       class="block text-center bg-blue-600 text-white font-medium py-2 rounded hover:bg-blue-700 transition">
                        Cek Jadwal & Book
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>