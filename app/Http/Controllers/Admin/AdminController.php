<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReservationStatus;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Table;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'menus' => Menu::count(),
            'categories' => Category::count(),
            'tables' => Table::count(),
            'reservations' => Reservation::count(),
        ];

        $pendingCount = Reservation::where('status', ReservationStatus::Pending)->count();

        $latestReservations = Reservation::with('table')
            ->latest('date')
            ->limit(5)
            ->get();

        return view('admin.index', compact('stats', 'pendingCount', 'latestReservations'));
    }
}
