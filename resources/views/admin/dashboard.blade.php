@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition
              {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span>📊</span> Dashboard
    </a>
    <a href="#"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition">
        <span>🏟️</span> Kelola Venue
    </a>
    <a href="#"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition">
        <span>🏸</span> Kelola Lapangan
    </a>
    <a href="#"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition">
        <span>📅</span> Kelola Booking
    </a>
    <a href="#"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition">
        <span>👥</span> Kelola User
    </a>
@endsection

@section('content')
{{-- ... isi konten dashboard tetap sama seperti sebelumnya ... --}}
@endsection