<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Fields;
use App\Models\Payments;
use App\Models\User;
use App\Models\Venues;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         if (auth()->user()?->role !== 'admin') {
    //             abort(403, 'Akses khusus admin.');
    //         }
    //         return $next($request);
    //     });
    // }

    public function dashboard()
    {
        $totalRevenue = Bookings::where('status', 'paid')->sum('total_price');
        $totalBookings = Bookings::count();
        $totalVenues = Venues::count();
        $totalFields = Fields::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $pendingPayments = Bookings::where('status', 'pending')->count();

        $bookingsToday = Bookings::whereDate('created_at', today())->count();

        $recentBookings = Bookings::with(['user', 'details.field.venue', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        $bookingsByStatus = Bookings::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $topFields = Fields::withCount(['details as bookings_count'])
            ->with('venue')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'totalVenues',
            'totalFields',
            'totalCustomers',
            'pendingPayments',
            'bookingsToday',
            'recentBookings',
            'bookingsByStatus',
            'topFields'
        ));
    }
}