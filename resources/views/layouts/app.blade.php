<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FitCourt - Reservasi Lapangan Olahraga')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100/70 text-gray-800 min-h-screen flex flex-col antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('landing.index') }}" class="flex items-center gap-2.5">
                    {{-- Logo Icon Energetik --}}
                    <div class="bg-blue-600 text-white p-2 rounded-xl flex items-center justify-center shadow-md shadow-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-extrabold text-slate-900 block leading-none tracking-tight">Fit<span class="text-blue-600">Court</span></span>
                        <span class="text-[10px] text-gray-400 block leading-tight font-medium mt-0.5">GOR Futsal & Badminton Sentosa</span>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-6 text-xs font-medium text-gray-600">
                    <a href="{{ route('landing.index') }}" class="text-blue-600 font-semibold border-b-2 border-blue-600 pb-5 pt-5">Daftar Lapangan</a>
                    <a href="#" class="hover:text-blue-600 transition py-5">Jadwal & Ketersediaan</a>
                    <a href="#" class="hover:text-blue-600 transition py-5">Riwayat Booking</a>
                    <a href="#" class="hover:text-blue-600 transition py-5">Lokasi & Fasilitas</a>
                </div>
            </div>

            <div class="flex items-center gap-3 text-xs">
                @auth
                    <span class="text-gray-600 hidden sm:inline">Hai, <strong class="text-gray-800">{{ auth()->user()->name }}</strong></span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-600 font-medium hover:underline border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 font-medium px-3 py-2 rounded-lg hover:bg-gray-100 transition">Masuk</a>
                    <a href="{{ route('register') }}"
                       class="bg-blue-600 text-white font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Isi Halaman --}}
    <main class="flex-1 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">

            {{-- Flash message --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-4 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="bg-emerald-500 text-white rounded-full p-0.5 text-[10px]">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('warning'))
                <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl mb-4 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ session('warning') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-4 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <span>🚨</span>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-auto text-xs text-gray-500 pt-10 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-gray-100">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="bg-blue-600 text-white p-1 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <span class="font-extrabold text-gray-900 text-sm tracking-tight">Fit<span class="text-blue-600">Court</span></span>
                    </div>
                    <p class="text-gray-400 max-w-sm mb-3 text-[11px] leading-relaxed">
                        Platform pemesanan dan jadwal lapangan olahraga online terintegrasi untuk GOR Futsal & Badminton Sentosa. Pesan lapangan kapan saja tanpa perlu antri telepon.
                    </p>
                    <p class="text-gray-400 text-[11px]">Alamat: Jl. Olahraga Sentosa No. 88, Komplek Gelanggang Remaja</p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 uppercase tracking-wider text-[11px] mb-3">TAUTAN CEPAT</h4>
                    <ul class="space-y-2 text-gray-500">
                        <li><a href="#" class="hover:text-blue-600">Panduan Cara Booking</a></li>
                        <li><a href="#" class="hover:text-blue-600">Kebijakan Reschedule</a></li>
                        <li><a href="#" class="hover:text-blue-600">Sewa Raket & Bola</a></li>
                        <li><a href="#" class="hover:text-blue-600">Member Bulanan Komunitas</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 uppercase tracking-wider text-[11px] mb-3">JAM OPERASIONAL GOR</h4>
                    <p class="text-gray-600 font-medium">Senin - Minggu:</p>
                    <p class="text-gray-800 font-bold mb-3">07:00 - 24:00 WIB</p>
                    <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-[11px] font-medium border border-emerald-200">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Sedang Beroperasi Hari Ini
                    </div>
                </div>
            </div>
            <div class="pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-[11px] text-gray-400">
                <p>&copy; {{ date('Y') }} FitCourt. All rights reserved. GOR Sentosa Arena.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:underline">Syarat & Ketentuan</a>
                    <a href="#" class="hover:underline">Kebijakan Privasi</a>
                    <a href="#" class="hover:underline">Hubungi Pengelola</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>