<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // 1. Tampilkan Halaman Simulator Pembayaran / Invoice
    public function show($bookingId)
    {
        $booking = Bookings::with(['details.field.venue', 'payment'])->findOrFail($bookingId);

        // Pastikan hanya pemilik booking yang bisa lihat
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.simulator', compact('booking'));
    }

    // 2. Eksekusi Simulasi Pembayaran (Ubah Status ke 'paid')
    public function simulate(Request $request, $bookingId)
    {
        $booking = Bookings::findOrFail($bookingId);

        // Validasi agar booking yang sudah lunas tidak dibayar ulang
        if ($booking->status === 'paid') {
            return back()->with('error', 'Transaksi ini sudah lunas!');
        }

        try {
            DB::transaction(function () use ($booking, $request) {
                // A. Update status transaksi pada tabel `bookings`
                $booking->update([
                    'status' => 'paid'
                ]);

                // B. Catat histori pembayaran ke tabel `payments`
                Payments::create([
                    'booking_id'     => $booking->id,
                    'payment_method' => $request->payment_method ?? 'bank_transfer_mock',
                    'payments_status' => 'success',
                    'transaction_id' => 'SIM-' . strtoupper(\Illuminate\Support\Str::random(10)),
                    'paid_at'        => now(),
                ]);
            });

            return redirect()->route('booking.success', $booking->id)
                             ->with('success', 'Pembayaran berhasil dikonfirmasi! Slot jam kamu sudah aman.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}