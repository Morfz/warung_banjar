<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Enums\ReservationStatus;
use App\Enums\TableStatus;
use Carbon\Carbon;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use App\Models\Reservation;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function check()
    {
        return view('reservations.check', [
            'reservations' => collect(),
            'searched' => false,
        ]);
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:30'],
        ]);

        $reservations = Reservation::with('table')
            ->where('email', $validated['email'])
            ->where('phone', $validated['phone'])
            ->latest('date')
            ->get();

        return view('reservations.check', [
            'reservations' => $reservations,
            'searched' => true,
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);
    }

    public function index(Request $request)
    {
        $min_date = Carbon::now()->addMinutes(30);
        $max_date = Carbon::now()->addWeek();
        $tables = Table::query()
            ->get()
            ->sortBy(fn (Table $table) => (int) preg_replace('/\D+/', '', $table->name))
            ->values()
            ->map(function (Table $table) {
                $table->is_selectable = $table->status === TableStatus::Available;
                $table->unavailable_reason = $table->is_selectable ? null : 'Tidak tersedia';

                return $table;
            });

        return view('reservations.index', compact('min_date', 'max_date', 'tables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:30'],
            'date' => ['required', 'date', new DateBetween, new TimeBetween],
            'guests' => ['required', 'integer', 'min:1', 'max:20'],
            'table_id' => ['required', Rule::exists('tables', 'id')],
        ]);

        $date = Carbon::parse($validated['date']);

        $table = Table::where('status', TableStatus::Available)
            ->where('capacity', '>=', $validated['guests'])
            ->find($validated['table_id']);

        if (! $table) {
            return back()
                ->withInput()
                ->with('warning', 'Meja yang dipilih tidak tersedia atau kapasitasnya kurang untuk jumlah tamu.');
        }

        if ($this->reservedTableIds($date, $validated['guests'])->contains($table->id)) {
            return back()
                ->withInput()
                ->with('warning', 'Meja ini sudah dipesan pada jam tersebut. Silakan pilih meja atau waktu lain.');
        }

        Reservation::create($validated);

        return to_route('reservations.check')
            ->with('success', 'Reservasi berhasil dibuat dan sedang menunggu konfirmasi admin. Masukkan email dan nomor telepon untuk melihat detail reservasi Anda.');
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
        })->pluck('table_id');
    }
}
