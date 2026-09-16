<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - FitCourt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-gray-800 min-h-screen flex flex-col justify-center items-center p-4 antialiased relative overflow-x-hidden">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-b from-blue-600/20 to-transparent blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-8">
        
        {{-- Brand Header FitCourt --}}
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
                <h2 class="text-xl font-bold text-gray-900">Daftar Akun Baru</h2>
                <p class="text-xs text-gray-500 mt-1">Buat akun untuk pesan dan cek jadwal lapangan online</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 p-3.5 rounded-xl mb-5 text-xs space-y-1">
                    <div class="font-bold flex items-center gap-1.5 mb-1">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Gagal Mendaftar:</span>
                    </div>
                    @foreach($errors->all() as $error)
                        <p class="pl-5 relative before:content-['•'] before:absolute before:left-2 text-rose-600">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           placeholder="Contoh: Budi Santoso"
                           class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded-xl text-xs font-medium text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           placeholder="nama@email.com"
                           class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded-xl text-xs font-medium text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nomor WhatsApp / HP (Opsional)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890" 
                           class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded-xl text-xs font-medium text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" name="password" required 
                           placeholder="••••••••"
                           class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded-xl text-xs font-medium text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required 
                           placeholder="••••••••"
                           class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded-xl text-xs font-medium text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2 mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>Daftar Sekarang</span>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Login disini</a>
                </p>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('landing.index') }}" class="text-xs text-slate-400 hover:text-white transition inline-flex items-center gap-1">
                &larr; Kembali ke Beranda Katalog
            </a>
        </div>
    </div>

</body>
</html>