<?php

namespace App\Http\Controllers;

use App\Models\BookingDetails;
use App\Models\Bookings;
use App\Models\Fields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Perbaikan: 'I' Harus Kapital

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'selected_hours' => 'required',
        ]);

        // 2. Format Input Jam
        $selectedHours = $request->selected_hours;

        if (is_string($selectedHours)) {
            $selectedHours = json_decode($selectedHours, true);
        }

        if (empty($selectedHours) || !is_array($selectedHours)) {
            return back()->with('error', 'Pilih minimal satu slot jam!');
        }

        // Ambil data lapangan
        $field = Fields::with('venue')->findOrFail($request->field_id);
        $totalPrice = count($selectedHours) * $field->price_per_hour;
        $bookingDate = $request->booking_date;

        return view('checkout.index', compact('field', 'selectedHours', 'totalPrice', 'bookingDate'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date',
            'selected_hours' => 'required|array',
        ]);

        $field = Fields::findOrFail($request->field_id);
        $selectedHours = $request->selected_hours;
        $bookingDate = $request->booking_date;

        try {
            $booking = DB::transaction(function () use ($field, $selectedHours, $bookingDate) {
                
                // A. Cegah Double Booking
                $alreadyBooked = BookingDetails::where('field_id', $field->id)
                    ->whereHas('booking', function ($query) use ($bookingDate) {
                        $query->where('booking_date', $bookingDate)
                              ->whereIn('status', ['paid', 'pending']);
                    })
                    ->whereIn('start_time', $selectedHours)
                    ->exists();

                if ($alreadyBooked) {
                    throw new \Exception('Maaf, salah satu jam yang kamu pilih baru saja dipesan orang lain.');
                }

                // B. Hitung Total Harga
                $totalPrice = count($selectedHours) * $field->price_per_hour;

                // C. Simpan Header Transaksi ke Tabel `bookings`
                $booking = Bookings::create([
                    'booking_code' => 'BK-' . strtoupper(Str::random(8)),
                    'user_id'      => Auth::id(),
                    'booking_date' => $bookingDate,
                    'total_price'  => $totalPrice,
                    'status'       => 'pending',
                ]);

                // D. Simpan Detail Slot Jam ke Tabel `booking_details`
                foreach ($selectedHours as $hour) {
                    $startTime = strlen($hour) === 5 ? $hour . ':00' : $hour;
                    $endTime   = date('H:i:s', strtotime($startTime . ' +1 hour'));

                    BookingDetails::create([
                        'booking_id' => $booking->id,
                        'field_id'   => $field->id,
                        'start_time' => $startTime,
                        'end_time'   => $endTime,
                        'price'      => $field->price_per_hour,
                    ]);
                }

                return $booking;
            });

            // Berhasil! Langsung arahkan ke Payment Simulator
            return redirect()->route('payment.show', $booking->id)
                             ->with('success', 'Pemesanan berhasil dibuat! Silakan selesaikan pembayaran.');

        } catch (\Exception $e) {
            // Tampilkan pesan error ke session agar terlihat jika gagal
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}