<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitCourt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-gray-800 min-h-screen flex flex-col justify-center items-center p-4 antialiased relative overflow-x-hidden">

    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-b from-blue-600/20 to-transparent blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-8">
        
        {{-- Logo / Brand Header FitCourt --}}
        <div class="text-center mb-6">
            <a href="{{ route('landing.index') }}" class="inline-flex items-center gap-2.5 group">
                <div class="bg-blue-600 text-white p-2 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-105 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="text-left">
                    <span class="text-xl font-extrabold text-white block leading-none tracking-tight">Fit<span class="text-blue-500">Court</span></span>
                    <span class="text-[10px] text-slate-400 block leading-tight mt-0.5">GOR Futsal & Badminton Sentosa</span>
                </div>
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-2xl border border-gray-100">
            <div class="mb-6 text-center">
                <h2 class="text-xl font-bold text-gray-900">Masuk ke Akun</h2>
                <p class="text-xs text-gray-500 mt-1">Masuk ke akunmu untuk melanjutkan booking</p>
            </div>

            {{-- Alert Pesan Error / Notifikasi Session --}}
            @if(session('warning'))
                <div class="bg-amber-50 border border-amber-200 text-amber-800 p-3.5 rounded-xl mb-4 text-xs flex items-center gap-2">
                    <span>⚠️</span>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3.5 rounded-xl mb-4 text-xs flex items-center gap-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 p-3.5 rounded-xl mb-4 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Alamat Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="nama@email.com"
                        required 
                        class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded-xl text-xs font-medium text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="••••••••"
                        required 
                        class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded-xl text-xs font-medium text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-lg shadow-blue-600/20 mt-2"
                >
                    Masuk Sekarang
                </button>
            </form>

            {{-- Footer / Link Register --}}
            <div class="mt-6 pt-5 border-t border-gray-100 text-center text-xs text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">
                    Daftar akun baru disini
                </a>
            </div>
        </div>

        {{-- Kembali ke Beranda --}}
        <div class="text-center mt-6">
            <a href="{{ route('landing.index') }}" class="text-xs text-slate-400 hover:text-white transition inline-flex items-center gap-1">
                &larr; Kembali ke Beranda Katalog
            </a>
        </div>
    </div>

</body>
</html>