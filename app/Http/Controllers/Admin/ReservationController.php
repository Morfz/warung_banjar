<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReservationStatus;
use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('table')->latest('date')->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $tables = Table::where('status', TableStatus::Available)->orderBy('name')->get();
        $statuses = ReservationStatus::cases();

        return view('admin.reservations.create', compact('tables', 'statuses'));
    }

    public function store(ReservationStoreRequest $request)
    {
        $table = Table::findOrFail($request->table_id);

        if ($table->status !== TableStatus::Available) {
            return back()->with('warning', 'Meja ini tidak tersedia.')->withInput();
        }

        if ($request->guests > $table->capacity) {
            return back()->with('warning', 'Jumlah tamu melebihi kapasitas meja.')->withInput();
        }

        $requestDate = Carbon::parse($request->date);

        if ($this->reservedTableIds($requestDate, $request->guests)->contains($table->id)) {
            return back()->with('warning', 'Meja ini sudah dipesan pada jam tersebut.')->withInput();
        }

        Reservation::create($request->validated());

        return to_route('admin.reservations.index')->with('success', 'Reservasi berhasil dibuat.');
    }

    public function show(Reservation $reservation)
    {
        return redirect()->route('admin.reservations.edit', $reservation);
    }

    public function edit(Reservation $reservation)
    {
        $tables = Table::where('status', TableStatus::Available)
            ->orWhere('id', $reservation->table_id)
            ->orderBy('name')
            ->get();

        $statuses = ReservationStatus::cases();

        return view('admin.reservations.edit', compact('reservation', 'tables', 'statuses'));
    }

    public function update(ReservationStoreRequest $request, Reservation $reservation)
    {
        $table = Table::findOrFail($request->table_id);

        if ($request->guests > $table->capacity) {
            return back()->with('warning', 'Jumlah tamu melebihi kapasitas meja.')->withInput();
        }

        $requestDate = Carbon::parse($request->date);

        if ($this->reservedTableIds($requestDate, $request->guests, $reservation->id)->contains($table->id)) {
            return back()->with('warning', 'Meja ini sudah dipesan pada jam tersebut.')->withInput();
        }

        $reservation->update($request->validated());

        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(ReservationStatus::class)],
        ]);

        $reservation->update($validated);
        $label = ReservationStatus::from($validated['status'])->label();

        return to_route('admin.reservations.index')
            ->with('success', 'Status reservasi diubah menjadi "' . $label . '".');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return to_route('admin.reservations.index')->with('success', 'Reservasi berhasil dihapus.');
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

    private function reservedTableIds(Carbon $date, int $guests, ?int $ignoreReservationId = null)
    {
        $reservations = Reservation::query()
            ->whereIn('status', [
                ReservationStatus::Pending->value,
                ReservationStatus::Confirmed->value,
            ])
            ->when($ignoreReservationId, fn ($query) => $query->whereKeyNot($ignoreReservationId))
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
        })->pluck('table_id');
    }
}
