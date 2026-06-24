<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\Table;
use App\Enums\TableStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        // Fetch all active tables for walk-in booking map
        $tables = Table::query()
            ->get()
            ->sortBy(fn (Table $table) => (int) preg_replace('/\D+/', '', $table->name))
            ->values();

        return view('receptionist.index', compact('reservations', 'search', 'status', 'date', 'tables'));
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

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d H:i',
            'guests' => 'required|integer|min:1',
        ]);

        $date = Carbon::parse($request->date);
        $guests = $request->guests;

        $reservedTableIds = $this->reservedTableIds($date, $guests);

        return response()->json([
            'reserved_table_ids' => $reservedTableIds,
        ]);
    }

    public function storeWalkin(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:30'],
            'date' => ['required', 'date_format:Y-m-d H:i'],
            'guests' => ['required', 'integer', 'min:1', 'max:20'],
            'table_id' => ['required', Rule::exists('tables', 'id')],
        ]);

        // Default email if not provided for walk-in
        if (empty($validated['email'])) {
            $validated['email'] = 'walkin_' . time() . '@warungbanjar.com';
        }

        $date = Carbon::parse($validated['date']);

        $table = Table::where('status', TableStatus::Available)
            ->where('capacity', '>=', $validated['guests'])
            ->find($validated['table_id']);

        if (! $table) {
            return back()->withInput()->with('warning', 'Meja yang dipilih tidak tersedia atau kapasitasnya kurang.');
        }

        if ($this->reservedTableIds($date, $validated['guests'])->contains($table->id)) {
            return back()->withInput()->with('warning', 'Meja ini sudah dipesan pada jam tersebut.');
        }

        // Walk-in is automatically Confirmed
        $validated['status'] = ReservationStatus::Confirmed->value;

        Reservation::create($validated);

        return back()->with('success', 'Reservasi walk-in berhasil dibuat!');
    }

    private function getDurationByGuests(int $guests): int
    {
        if ($guests <= 2) {
            return 60; // 1 hour
        }
        if ($guests <= 4) {
            return 90; // 1.5 hours
        }
        return 120; // 2 hours
    }

    private function reservedTableIds(Carbon $date, int $guests)
    {
        $reservations = Reservation::whereIn('status', [
                ReservationStatus::Pending->value,
                ReservationStatus::Confirmed->value,
                ReservationStatus::Completed->value,
            ])
            ->whereDate('date', $date->toDateString())
            ->get();

        $newStart = $date;
        $newDuration = $this->getDurationByGuests($guests);
        $newEnd = $date->copy()->addMinutes($newDuration);

        return $reservations->filter(function ($res) use ($newStart, $newEnd) {
            $resStart = Carbon::parse($res->date);
            $resDuration = $this->getDurationByGuests($res->guests);
            $resEnd = $resStart->copy()->addMinutes($resDuration);

            return $resStart->lt($newEnd) && $newStart->lt($resEnd);
        })->pluck('table_id')->values();
    }
}
