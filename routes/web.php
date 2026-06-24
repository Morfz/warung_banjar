<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\Frontend\AboutController as FrontendAboutController;
use App\Http\Controllers\Frontend\ContactController as FrontendContactController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\ReceptionistController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        $database = 'ok';
    } catch (Throwable $exception) {
        $database = $exception->getMessage();
    }

    $tables = [];
    foreach (['categories', 'menus', 'category_menu', 'tables', 'reservations', 'users'] as $table) {
        try {
            $tables[$table] = Schema::hasTable($table) ? DB::table($table)->count() : 'missing';
        } catch (Throwable $exception) {
            $tables[$table] = $exception->getMessage();
        }
    }

    return response()->json([
        'status' => 'ok',
        'app' => config('app.name'),
        'env' => app()->environment(),
        'database' => $database,
        'tables' => $tables,
    ]);
});

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/menus', [FrontendMenuController::class, 'index'])->name('menus.index');
Route::get('/about', [FrontendAboutController::class, 'index'])->name('about.index');
Route::get('/contact', [FrontendContactController::class, 'index'])->name('contact.index');
Route::get('/blog', [FrontendBlogController::class, 'index'])->name('blog.index');
Route::get('/reservation/check', [FrontendReservationController::class, 'check'])->name('reservations.check');
Route::post('/reservation/check', [FrontendReservationController::class, 'lookup'])->name('reservations.lookup');
Route::get('/reservation', [FrontendReservationController::class, 'index'])->name('reservations.index');
Route::post('/reservation', [FrontendReservationController::class, 'store'])->name('reservations.store');

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('categories', CategoryController::class);
    Route::resource('menus', MenuController::class);
    Route::get('/tables/layout', [TableController::class, 'layout'])->name('tables.layout');
    Route::put('/tables/layout', [TableController::class, 'updateLayout'])->name('tables.layout.update');
    Route::resource('tables', TableController::class);
    Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.status');
    Route::resource('reservations', ReservationController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('/dashboard', '/admin')->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Receptionist routes
    Route::get('/receptionist', [ReceptionistController::class, 'index'])->name('receptionist.index');
    Route::get('/receptionist/check-availability', [ReceptionistController::class, 'checkAvailability'])->name('receptionist.check-availability');
    Route::post('/receptionist/store-walkin', [ReceptionistController::class, 'storeWalkin'])->name('receptionist.store-walkin');
    Route::post('/receptionist/{reservation}/check-in', [ReceptionistController::class, 'checkIn'])->name('receptionist.check-in');
    Route::post('/receptionist/{reservation}/confirm', [ReceptionistController::class, 'confirm'])->name('receptionist.confirm');
    Route::post('/receptionist/{reservation}/cancel', [ReceptionistController::class, 'cancel'])->name('receptionist.cancel');
});

require __DIR__.'/auth.php';
