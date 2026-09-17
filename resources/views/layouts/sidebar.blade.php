<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FitCourt')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('head')
</head>
<body class="bg-gray-100/70 text-gray-800 antialiased">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-slate-900 text-white flex-col hidden lg:flex fixed h-full">
            <div class="h-16 flex items-center gap-2.5 px-5 border-b border-slate-800">
                <div class="bg-blue-600 text-white p-2 rounded-xl flex items-center justify-center shadow-md shadow-blue-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <span class="text-base font-extrabold block leading-none tracking-tight">Fit<span class="text-blue-500">Court</span></span>
                    <span class="text-[10px] text-slate-400 block leading-tight mt-0.5 capitalize">{{ auth()->user()->role }} Panel</span>
                </div>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1 text-sm">
                @yield('sidebar-menu')
            </nav>

            <div class="p-3 border-t border-slate-800">
                <div class="px-3 py-2 mb-2">
                    <p class="text-xs font-semibold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400">{{ auth()->user()->email }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-red-400 hover:bg-red-500/10 transition text-sm">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Konten Utama --}}
        <div class="flex-1 lg:ml-64">

            <header class="bg-white border-b border-gray-200 h-16 flex items-center px-4 lg:px-8 sticky top-0 z-40">
                <h1 class="text-sm font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
            </header>

            <main class="p-4 lg:p-8">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-4 text-xs flex items-center gap-2 shadow-sm">
                        <span class="bg-emerald-500 text-white rounded-full p-0.5 text-[10px]">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-4 text-xs flex items-center gap-2 shadow-sm">
                        <span>🚨</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>