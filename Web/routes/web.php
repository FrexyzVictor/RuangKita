<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EvaluasiController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;

// GURU CONTROLLER
use App\Http\Controllers\GuruController;

// SISWA CONTROLLER
use App\Http\Controllers\Siswa\HomeController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ============================================================
// ROOT
// ============================================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

    // ================= BOOKING =================
    Route::prefix('bookings')->name('bookings.')->group(function () {

        Route::get('/', [
            BookingController::class,
            'index'
        ])->name('index');

        Route::get('/{id}', [
            BookingController::class,
            'show'
        ])->name('show');

        Route::patch('/{id}/approve', [
            BookingController::class,
            'approve'
        ])->name('approve');

        Route::patch('/{id}/cancel', [
            BookingController::class,
            'cancel'
        ])->name('cancel');

        Route::delete('/{id}', [
            BookingController::class,
            'destroy'
        ])->name('destroy');
    });

    // ================= FASILITAS =================
    Route::prefix('fasilitas')->name('fasilitas.')->group(function () {

        Route::get('/', [
            FasilitasController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            FasilitasController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            FasilitasController::class,
            'store'
        ])->name('store');

        Route::get('/{id}', [
            FasilitasController::class,
            'show'
        ])->name('show');

        Route::get('/{id}/edit', [
            FasilitasController::class,
            'edit'
        ])->name('edit');

        Route::put('/{id}', [
            FasilitasController::class,
            'update'
        ])->name('update');

        Route::delete('/{id}', [
            FasilitasController::class,
            'destroy'
        ])->name('destroy');

        Route::patch('/{id}/toggle', [
            FasilitasController::class,
            'toggleStatus'
        ])->name('toggle');
    });

    // ================= JADWAL =================
    Route::prefix('jadwal')->name('jadwal.')->group(function () {

        Route::get('/', [
            JadwalController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            JadwalController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            JadwalController::class,
            'store'
        ])->name('store');

        Route::get('/{id}/edit', [
            JadwalController::class,
            'edit'
        ])->name('edit');

        Route::put('/{id}', [
            JadwalController::class,
            'update'
        ])->name('update');

        Route::delete('/{id}', [
            JadwalController::class,
            'destroy'
        ])->name('destroy');

        Route::patch('/{id}/toggle', [
            JadwalController::class,
            'toggle'
        ])->name('toggle');
    });

    // ================= USERS =================
    Route::prefix('users')->name('users.')->group(function () {

        Route::get('/', [
            UserController::class,
            'index'
        ])->name('index');

        Route::get('/{id}', [
            UserController::class,
            'show'
        ])->name('show');

        Route::get('/{id}/edit', [
            UserController::class,
            'edit'
        ])->name('edit');

        Route::put('/{id}', [
            UserController::class,
            'update'
        ])->name('update');

        Route::delete('/{id}', [
            UserController::class,
            'destroy'
        ])->name('destroy');
    });

    // ================= EVALUASI =================
    Route::prefix('evaluasi')->name('evaluasi.')->group(function () {

        Route::get('/', [
            EvaluasiController::class,
            'index'
        ])->name('index');

        Route::get('/{id}', [
            EvaluasiController::class,
            'show'
        ])->name('show');

        Route::delete('/{id}', [
            EvaluasiController::class,
            'destroy'
        ])->name('destroy');
    });

    // ================= KATEGORI =================
    Route::prefix('kategori')->name('kategori.')->group(function () {

        Route::get('/', [
            KategoriController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            KategoriController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            KategoriController::class,
            'store'
        ])->name('store');

        Route::get('/{id}/edit', [
            KategoriController::class,
            'edit'
        ])->name('edit');

        Route::put('/{id}', [
            KategoriController::class,
            'update'
        ])->name('update');

        Route::delete('/{id}', [
            KategoriController::class,
            'destroy'
        ])->name('destroy');
    });

    // ================= LAPORAN =================
    Route::get('/laporan/export', [
        LaporanController::class,
        'export'
    ])->name('laporan.export');

    Route::get('/laporan', [
        LaporanController::class,
        'index'
    ])->name('laporan.index');

});

// ============================================================
// SISWA ROUTES
// ============================================================
Route::get('/home-siswa', [
    HomeController::class,
    'index'
])->name('home.siswa');

Route::get('/fasilitas', [
    HomeController::class,
    'fasilitas'
])->name('fasilitas');

Route::get('/booking-search', function () {
    return 'Halaman Search Booking';
})->name('siswa.booking.search');

Route::get('/booking', [
    HomeController::class,
    'booking'
])->name('booking');

Route::get('/booking/{id}/create', [
    HomeController::class,
    'createBooking'
])->name('booking.create');

Route::get('/jadwal', [
    HomeController::class,
    'jadwal'
])->name('jadwal');

// ============================================================
// AUTH
// ============================================================

// Auth::routes();

// ============================================================
// FALLBACK
// ============================================================
Route::fallback(function () {

    return redirect('/admin/dashboard');

});

// ============================================================
// GURU ROUTES
// ============================================================
Route::get('/guru/dashboard', [
    GuruController::class,
    'dashboard'
]);

Route::get('/guru/status', [
    GuruController::class,
    'status'
]);

Route::get('/guru/booking', [
    GuruController::class,
    'booking'
]);

Route::get('/guru/fasilitas', [
    GuruController::class,
    'fasilitas'
]);