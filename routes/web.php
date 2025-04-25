<?php

use Illuminate\Support\Facades\Route;

// Middleware
use App\Http\Middleware\Authenticate;

// Admin
use App\Http\Controllers\Admin\{FasilitasController, JadwalController, PeminjamanController, OperatorController, RiwayatController};

// User
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;
use App\Http\Controllers\User\ProfilController as UserProfilController;
use App\Http\Controllers\User\RiwayatController as UserRiwayatController;

// Auth
use App\Http\Controllers\Auth\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Auth\User\LoginController as UserLoginController;

Route::get('/', fn() => view('welcome'));
Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

// Login & Logout
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.process');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});

Route::prefix('user')->group(function () {
    Route::get('login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
    Route::post('login', [UserLoginController::class, 'login']);
    Route::post('logout', [UserLoginController::class, 'logout'])->name('user.logout');
});

// Admin Routes
Route::prefix('admin')->middleware([Authenticate::class, 'role:admin'])->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard.dashboard'))->name('admin.dashboard');

    Route::prefix('fasilitas')->group(function () {
        Route::get('/', [FasilitasController::class, 'index'])->name('fasilitas');
        Route::get('/tambah', [FasilitasController::class, 'create'])->name('fasilitas.create');
        Route::post('/', [FasilitasController::class, 'store'])->name('fasilitas.store');
        Route::get('/{id}/edit', [FasilitasController::class, 'edit'])->name('fasilitas.edit');
        Route::put('/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
        Route::delete('/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');
    });

    Route::prefix('jadwal')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('jadwal');
        Route::get('/tambah', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    });

    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::get('/tambah', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::put('/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

        //persetujuan
        Route::patch('/admin/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    });

    Route::prefix('riwayat')->group(function () {
        Route::get('/', [RiwayatController::class, 'index'])->name('riwayat');
        Route::get('/detail/{id}', [RiwayatController::class, 'detail'])->name('riwayat.detail');
        Route::get('/print/{id}', [RiwayatController::class, 'print'])->name('riwayat.print');
    });

    Route::prefix('operator')->group(function () {
        Route::get('/', [OperatorController::class, 'index'])->name('operator');
        Route::get('/tambah', [OperatorController::class, 'create'])->name('operator.create');
        Route::post('/', [OperatorController::class, 'store'])->name('operator.store');
        Route::get('/{id}/edit', [OperatorController::class, 'edit'])->name('operator.edit');
        Route::put('/{id}', [OperatorController::class, 'update'])->name('operator.update');
        Route::delete('/{id}', [OperatorController::class, 'destroy'])->name('operator.destroy');
        Route::get('/{id}/detail', [OperatorController::class, 'detail'])->name('operator.detail');
    });
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->middleware([Authenticate::class, 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard', fn() => view('user.mahasiswa.dashboard'))->name('mahasiswa.dashboard');

    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [UserPeminjamanController::class, 'index'])->name('mahasiswa.peminjaman');
        Route::get('/tambah', [UserPeminjamanController::class, 'create'])->name('mahasiswa.peminjaman.create');
        Route::post('/', [UserPeminjamanController::class, 'store'])->name('mahasiswa.peminjaman.store');
        Route::get('/{id}/edit', [UserPeminjamanController::class, 'edit'])->name('mahasiswa.peminjaman.edit');
        Route::put('/{id}', [UserPeminjamanController::class, 'update'])->name('mahasiswa.peminjaman.update');
        Route::delete('/{id}', [UserPeminjamanController::class, 'destroy'])->name('mahasiswa.peminjaman.destroy');
    });

    Route::prefix('riwayat')->group(function () {
        Route::get('/', [UserRiwayatController::class, 'riwayat'])->name('mahasiswa.riwayat');
        Route::get('/{id}/detail', [UserRiwayatController::class, 'detail'])->name('mahasiswa.riwayat.detail');
    });

    Route::get('/profil', [UserProfilController::class, 'index'])->name('mahasiswa.profil');
});
