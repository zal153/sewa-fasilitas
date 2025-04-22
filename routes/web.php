<?php

//Admin
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\Admin\RiwayatController;

//User
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;
use Illuminate\Support\Facades\Route;

// Halaman welcome
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('admin.dashboard');

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
    });

    Route::prefix('riwayat')->group(function (){
        Route::get('/', [RiwayatController::class, 'riwayat'])->name('riwayat');
        Route::get('/{id}/detail', [RiwayatController::class, 'detail'])->name('riwayat.detail');
        Route::get('/{id}/konfirmasi', [RiwayatController::class, 'konfirmasi'])->name('riwayat.konfirmasi');
    });

    Route::prefix('operator')->group(function (){
        Route::get('/', [OperatorController::class, 'index'])->name('operator');
        Route::get('/tambah', [OperatorController::class, 'create'])->name('operator.create');
        Route::post('/', [OperatorController::class, 'store'])->name('operator.store');
        Route::get('/{id}/edit', [OperatorController::class, 'edit'])->name('operator.edit');
        Route::put('/{id}', [OperatorController::class, 'update'])->name('operator.update');
        Route::delete('/{id}', [OperatorController::class, 'destroy'])->name('operator.destroy');
        Route::get('/{id}/detail', [OperatorController::class, 'detail'])->name('operator.detail');
    });

});

Route::prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');

    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [UserPeminjamanController::class, 'index'])->name('mahasiswa.peminjaman');
        Route::get('/tambah', [UserPeminjamanController::class, 'create'])->name('mahasiswa.peminjaman.create');
        Route::post('/', [UserPeminjamanController::class, 'store'])->name('mahasiswa.peminjaman.store');
        Route::get('/{id}/edit', [UserPeminjamanController::class, 'edit'])->name('mahasiswa.peminjaman.edit');
        Route::put('/{id}', [UserPeminjamanController::class, 'update'])->name('mahasiswa.peminjaman.update');
        Route::delete('/{id}', [UserPeminjamanController::class, 'destroy'])->name('mahasiswa.peminjaman.destroy');
    });
});
