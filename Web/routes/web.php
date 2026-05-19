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

// AUTH CONTROLLERS
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ROOT — redirect ke login
Route::get('/', fn() => redirect()->route('login'));

// ============================================================
// AUTH ROUTES
// ============================================================
Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login',   [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout',  [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register',[RegisterController::class, 'register'])->middleware('guest');

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── BOOKING ───────────────────────────────────────────────
  Route::prefix('bookings')->name('bookings.')->group(function () {

    Route::get('/', [BookingController::class, 'index'])->name('index');

    Route::get('/create', [BookingController::class, 'create'])->name('create');

    Route::post('/', [BookingController::class, 'store'])->name('store');

    Route::get('/{id}', [BookingController::class, 'show'])->name('show');

    Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('edit');

    Route::put('/{id}', [BookingController::class, 'update'])->name('update');

    // Konfirmasi / aksi status
    Route::patch('/{id}/approve', [BookingController::class, 'approve'])->name('approve');

    Route::patch('/{id}/cancel', [BookingController::class, 'cancel'])->name('cancel');

    Route::patch('/{id}/selesai', [BookingController::class, 'selesai'])->name('selesai');

    // Pembayaran (pengunjung wajib bayar, siswa bebas bayar)
    Route::post('/{id}/catat-dp', [BookingController::class, 'catatDP'])->name('catat_dp');

    Route::post('/{id}/catat-pelunasan', [BookingController::class, 'catatPelunasan'])->name('catat_pelunasan');

    Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
});

    // ─── FASILITAS ────────────────────────────────────────────
    Route::prefix('fasilitas')->name('fasilitas.')->group(function () {
        Route::get('/',              [FasilitasController::class, 'index'])->name('index');
        Route::get('/create',        [FasilitasController::class, 'create'])->name('create');
        Route::post('/',             [FasilitasController::class, 'store'])->name('store');
        Route::get('/{id}',          [FasilitasController::class, 'show'])->name('show');
        Route::get('/{id}/edit',     [FasilitasController::class, 'edit'])->name('edit');
        Route::put('/{id}',          [FasilitasController::class, 'update'])->name('update');
        Route::delete('/{id}',       [FasilitasController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle', [FasilitasController::class, 'toggleStatus'])->name('toggle');
    });

    // ─── JADWAL ───────────────────────────────────────────────
    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/',              [JadwalController::class, 'index'])->name('index');
        Route::get('/create',        [JadwalController::class, 'create'])->name('create');
        Route::post('/',             [JadwalController::class, 'store'])->name('store');
        Route::get('/{id}/edit',     [JadwalController::class, 'edit'])->name('edit');
        Route::put('/{id}',          [JadwalController::class, 'update'])->name('update');
        Route::delete('/{id}',       [JadwalController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle', [JadwalController::class, 'toggle'])->name('toggle');
    });

   // ─── USERS ────────────────────────────────────────────────
Route::prefix('users')->name('users.')->group(function () {

    Route::get('/',          [UserController::class, 'index'])->name('index');

    Route::get('/create',    [UserController::class, 'create'])->name('create');

    Route::post('/',         [UserController::class, 'store'])->name('store');

    Route::get('/{id}',      [UserController::class, 'show'])->name('show');

    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');

    Route::put('/{id}',      [UserController::class, 'update'])->name('update');

    Route::delete('/{id}',   [UserController::class, 'destroy'])->name('destroy');

});

    // ─── EVALUASI ─────────────────────────────────────────────
    Route::prefix('evaluasi')->name('evaluasi.')->group(function () {
        Route::get('/',        [EvaluasiController::class, 'index'])->name('index');
        Route::get('/{id}',    [EvaluasiController::class, 'show'])->name('show');
        Route::delete('/{id}', [EvaluasiController::class, 'destroy'])->name('destroy');
    });

    // ─── KATEGORI ─────────────────────────────────────────────
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/',          [KategoriController::class, 'index'])->name('index');
        Route::get('/create',    [KategoriController::class, 'create'])->name('create');
        Route::post('/',         [KategoriController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{id}',      [KategoriController::class, 'update'])->name('update');
        Route::delete('/{id}',   [KategoriController::class, 'destroy'])->name('destroy');
    });

    // ─── LAPORAN ──────────────────────────────────────────────
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan',        [LaporanController::class, 'index'])->name('laporan.index');
});

// ============================================================
// GURU ROUTES
// ============================================================
Route::prefix('guru')->middleware(['auth', 'guru'])->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/status',    [GuruController::class, 'status'])->name('guru.status');
    Route::get('/booking',   [GuruController::class, 'booking'])->name('guru.booking');
    Route::get('/fasilitas', [GuruController::class, 'fasilitas'])->name('guru.fasilitas');
});

// ============================================================
// SISWA ROUTES
// ============================================================
Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('/home-siswa',          [HomeController::class, 'index'])->name('home.siswa');
    Route::get('/fasilitas',           [HomeController::class, 'fasilitas'])->name('fasilitas');
    Route::get('/booking',             [HomeController::class, 'booking'])->name('booking');
    Route::get('/booking/{id}/create', [HomeController::class, 'createBooking'])->name('booking.create');
    Route::get('/jadwal',              [HomeController::class, 'jadwal'])->name('jadwal');
    Route::get('/contact',             [HomeController::class, 'contact'])->name('contact');
    Route::post('/booking/store',      [HomeController::class, 'storeBooking'])->name('booking.store');
});

// ============================================================
// PENGUNJUNG ROUTES
// ============================================================
Route::middleware(['auth'])->prefix('pengunjung')->name('pengunjung.')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'pengunjung') abort(403);
        return view('pengunjung.home-siswa');
    })->name('dashboard');
});

// SISWA dashboard alias
Route::get('/siswa/dashboard', fn() => redirect()->route('home.siswa'))
     ->middleware(['auth', 'siswa'])->name('siswa.dashboard');

// ============================================================
// FALLBACK
// ============================================================
Route::fallback(function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect('/admin/dashboard'),
            'guru'  => redirect('/guru/dashboard'),
            'siswa' => redirect('/home-siswa'),
            default => redirect('/pengunjung/home-siswa'),
        };
    }
    return redirect()->route('login');
});