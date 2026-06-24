<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\Table;
use App\Enums\TableStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $date = $request->input('date', Carbon::today()->toDateString());

        $query = Reservation::with('table');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($date && !$search) {
            $query->whereDate('date', $date);
        }

        $reservations = $query->orderBy('date', 'asc')->get();

        return view('receptionist.index', compact('reservations', 'search', 'status', 'date'));
    }

    public function checkIn(Reservation $reservation)
    {
        $reservation->update([
            'status' => ReservationStatus::Completed, // Selesai / Tamu Hadir
        ]);

        return back()->with('success', "Tamu {$reservation->name} berhasil di-check-in (Tamu Hadir).");
    }

    public function cancel(Reservation $reservation)
    {
        $reservation->update([
            'status' => ReservationStatus::Cancelled,
        ]);

        return back()->with('success', "Reservasi untuk {$reservation->name} berhasil dibatalkan.");
    }

    public function confirm(Reservation $reservation)
    {
        $reservation->update([
            'status' => ReservationStatus::Confirmed,
        ]);

        return back()->with('success', "Reservasi untuk {$reservation->name} telah dikonfirmasi.");
    }
}
