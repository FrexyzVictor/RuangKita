
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
use App\Http\Controllers\GuruController;
// HOME CONTROLLER
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ============================================================
// ROOT
// ============================================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================================
// AUTH ROUTES
// ============================================================
Auth::routes(['register' => false]);

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [
        \App\Http\Controllers\Admin\DashboardController::class,
        'index'
    ])->name('dashboard');

    // ================= BOOKING =================
    Route::prefix('bookings')->name('bookings.')->group(function () {

        Route::get('/', [
            \App\Http\Controllers\Admin\BookingController::class,
            'index'
        ])->name('index');

        Route::get('/{id}', [
            \App\Http\Controllers\Admin\BookingController::class,
            'show'
        ])->name('show');

        Route::patch('/{id}/approve', [
            \App\Http\Controllers\Admin\BookingController::class,
            'approve'
        ])->name('approve');

        Route::patch('/{id}/cancel', [
            \App\Http\Controllers\Admin\BookingController::class,
            'cancel'
        ])->name('cancel');

        Route::delete('/{id}', [
            \App\Http\Controllers\Admin\BookingController::class,
            'destroy'
        ])->name('destroy');
    });

    // ================= FASILITAS =================
    Route::prefix('fasilitas')->name('fasilitas.')->group(function () {

        Route::get('/', [
            \App\Http\Controllers\Admin\FasilitasController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            \App\Http\Controllers\Admin\FasilitasController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            \App\Http\Controllers\Admin\FasilitasController::class,
            'store'
        ])->name('store');

        Route::get('/{id}', [
            \App\Http\Controllers\Admin\FasilitasController::class,
            'show'
        ])->name('show');

        Route::get('/{id}/edit', [
            \App\Http\Controllers\Admin\FasilitasController::class,
            'edit'
        ])->name('edit');

        Route::put('/{id}', [
            \App\Http\Controllers\Admin\FasilitasController::class,
            'update'
        ])->name('update');

        Route::delete('/{id}', [
            \App\Http\Controllers\Admin\FasilitasController::class,
            'destroy'
        ])->name('destroy');

        Route::patch('/{id}/toggle', [
            \App\Http\Controllers\Admin\FasilitasController::class,
            'toggleStatus'
        ])->name('toggle');
    });

    // ================= JADWAL =================
    Route::prefix('jadwal')->name('jadwal.')->group(function () {

        Route::get('/', [
            \App\Http\Controllers\Admin\JadwalController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            \App\Http\Controllers\Admin\JadwalController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            \App\Http\Controllers\Admin\JadwalController::class,
            'store'
        ])->name('store');

        Route::get('/{id}/edit', [
            \App\Http\Controllers\Admin\JadwalController::class,
            'edit'
        ])->name('edit');

        Route::put('/{id}', [
            \App\Http\Controllers\Admin\JadwalController::class,
            'update'
        ])->name('update');

        Route::delete('/{id}', [
            \App\Http\Controllers\Admin\JadwalController::class,
            'destroy'
        ])->name('destroy');

        Route::patch('/{id}/toggle', [
            \App\Http\Controllers\Admin\JadwalController::class,
            'toggle'
        ])->name('toggle');
    });

    // ================= USERS =================
    Route::prefix('users')->name('users.')->group(function () {

        Route::get('/', [
            \App\Http\Controllers\Admin\UserController::class,
            'index'
        ])->name('index');

        Route::get('/{id}', [
            \App\Http\Controllers\Admin\UserController::class,
            'show'
        ])->name('show');

        Route::get('/{id}/edit', [
            \App\Http\Controllers\Admin\UserController::class,
            'edit'
        ])->name('edit');

        Route::put('/{id}', [
            \App\Http\Controllers\Admin\UserController::class,
            'update'
        ])->name('update');

        Route::delete('/{id}', [
            \App\Http\Controllers\Admin\UserController::class,
            'destroy'
        ])->name('destroy');
    });

    // ================= EVALUASI =================
    Route::prefix('evaluasi')->name('evaluasi.')->group(function () {

        Route::get('/', [
            \App\Http\Controllers\Admin\EvaluasiController::class,
            'index'
        ])->name('index');

        Route::get('/{id}', [
            \App\Http\Controllers\Admin\EvaluasiController::class,
            'show'
        ])->name('show');

        Route::delete('/{id}', [
            \App\Http\Controllers\Admin\EvaluasiController::class,
            'destroy'
        ])->name('destroy');
    });

    // ================= KATEGORI =================
    Route::prefix('kategori')->name('kategori.')->group(function () {

        Route::get('/', [
            \App\Http\Controllers\Admin\KategoriController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            \App\Http\Controllers\Admin\KategoriController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            \App\Http\Controllers\Admin\KategoriController::class,
            'store'
        ])->name('store');

        Route::get('/{id}/edit', [
            \App\Http\Controllers\Admin\KategoriController::class,
            'edit'
        ])->name('edit');

        Route::put('/{id}', [
            \App\Http\Controllers\Admin\KategoriController::class,
            'update'
        ])->name('update');

        Route::delete('/{id}', [
            \App\Http\Controllers\Admin\KategoriController::class,
            'destroy'
        ])->name('destroy');
    });

    // ================= LAPORAN =================
    Route::get('/laporan/export', [
        \App\Http\Controllers\Admin\LaporanController::class,
        'export'
    ])->name('laporan.export');

    Route::get('/laporan', [
        \App\Http\Controllers\Admin\LaporanController::class,
        'index'
    ])->name('laporan.index');

});

// ============================================================
// SISWA PAGE ROUTE
// ============================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/siswa', function () {
        return view('Home.siswa');
    })->name('siswa.home');

});

// ============================================================
// FALLBACK
// ============================================================
Route::fallback(function () {

    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('login');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//==== GURU ======

Route::get('/guru/dashboard', [GuruController::class, 'dashboard']);
Route::get('/guru/status', [GuruController::class, 'status']);
Route::get('/guru/booking', [GuruController::class, 'booking']);
