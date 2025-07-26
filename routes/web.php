<?php

use App\Http\Middleware\Authenticate;

// Middleware
use Illuminate\Support\Facades\Route;

// Admin
use App\Http\Controllers\BayarController;
use App\Http\Controllers\NotificationController;

// User
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\NonMahasiswa\NonPeminjamanController;
use App\Http\Controllers\User\ProfilController as UserProfilController;

// Non-Mahasiswa Routes
use App\Http\Controllers\User\RiwayatController as UserRiwayatController;
use App\Http\Controllers\Auth\User\LoginController as UserLoginController;
use App\Http\Controllers\Auth\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\NonMahasiswaController as EksternalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;


// Auth
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;
use App\Http\Controllers\NonMahasiswa\DashboardController as NonDashboardController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;

// Import Admin NotificationController
use App\Http\Controllers\NonMahasiswa\NonPembayaranController as NonPembayaranController;
use App\Http\Controllers\NonMahasiswa\NonMahasiswaRiwayatController as NonHistoryController;
use App\Http\Controllers\Admin\{FasilitasController, JadwalController, PeminjamanController, OperatorController, RiwayatController, PembayaranController};

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

Route::prefix('register')->group(function () {
    Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/', [RegisterController::class, 'register']);
});

// Routes untuk User/Mahasiswa/Non-Mahasiswa Notifications
Route::middleware('auth')->group(function () {
    // Halaman notifikasi untuk user
    Route::get('/notifications/page', [NotificationController::class, 'page'])->name('notifications.page');

    // API untuk dropdown user
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Actions untuk halaman user
    Route::delete('/notifications/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::post('/notifications/bulk-delete', [NotificationController::class, 'bulkDelete'])->name('notifications.bulk-delete');
    Route::post('/notifications/bulk-mark-read', [NotificationController::class, 'bulkMarkAsRead'])->name('notifications.bulk-mark-read');
});

// Admin Routes
Route::prefix('admin')->middleware([Authenticate::class, 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/data', [AdminDashboardController::class, 'getData'])->name('admin.dashboard.data');

    // Admin Notifications - Menggunakan AdminNotificationController
    Route::prefix('notifications')->group(function () {
        Route::get('/', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::get('/unread-count', [AdminNotificationController::class, 'getUnreadCount'])->name('admin.notifications.unreadCount');
        Route::get('/{id}/mark-as-read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
        Route::get('/mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');
        Route::delete('/{id}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');
    });

    Route::prefix('mahasiswa')->group(function () {
        Route::get('/', [AdminMahasiswaController::class, 'index'])->name('mahasiswa');
        Route::get('/tambah', [AdminMahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/', [AdminMahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/{id}/edit', [AdminMahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/{id}', [AdminMahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::delete('/{id}', [AdminMahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    });

    Route::prefix('eksternal')->group(function () {
        Route::get('/', [EksternalController::class, 'index'])->name('eksternal');
        Route::get('/tambah', [EksternalController::class, 'create'])->name('eksternal.create');
        Route::post('/', [EksternalController::class, 'store'])->name('eksternal.store');
        Route::get('/{id}/edit', [EksternalController::class, 'edit'])->name('eksternal.edit');
        Route::put('/{id}', [EksternalController::class, 'update'])->name('eksternal.update');
        Route::delete('/{id}', [EksternalController::class, 'destroy'])->name('eksternal.destroy');
    });

    Route::prefix('fasilitas')->group(function () {
        Route::get('/', [FasilitasController::class, 'index'])->name('fasilitas');
        Route::get('/tambah', [FasilitasController::class, 'create'])->name('fasilitas.create');
        Route::post('/', [FasilitasController::class, 'store'])->name('fasilitas.store');
        Route::get('/{id}/edit', [FasilitasController::class, 'edit'])->name('fasilitas.edit');
        Route::put('/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
        Route::delete('/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');
        Route::put('/{id}/status', [PeminjamanController::class, 'updateStatus'])->name('fasilitas.updateStatus');
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

        Route::get('/pending', [PeminjamanController::class, 'pending'])->name('admin.peminjaman.pending');

        //persetujuan
        Route::patch('/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
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

    Route::prefix('pembayaran')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('pembayaran');
        Route::get('/{id}/detail', [PembayaranController::class, 'detail'])->name('pembayaran.detail');
        Route::get('/{id}/print', [PembayaranController::class, 'print'])->name('pembayaran.print');
        Route::get('/{id}/approve', [PembayaranController::class, 'approve'])->name('pembayaran.approve');
        Route::delete('/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
        Route::put('/{id}/status', [PembayaranController::class, 'updateStatus'])->name('pembayaran.updateStatus');

        Route::post('/{id}/approve', [PembayaranController::class, 'approve'])->name('admin.pembayaran.approve');
        Route::post('/{id}/reject', [PembayaranController::class, 'reject'])->name('admin.pembayaran.reject');
    });
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->middleware([Authenticate::class, 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('mahasiswa.dashboard');

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
        Route::get('/{id}/print', [UserRiwayatController::class, 'print'])->name('mahasiswa.riwayat.print');
        Route::delete('/{id}', [UserRiwayatController::class, 'destroy'])->name('mahasiswa.riwayat.delete');
    });

    Route::get('/profil', [UserProfilController::class, 'index'])->name('mahasiswa.profil');
});

Route::prefix('non_mahasiswa')->middleware([Authenticate::class, 'role:non_mahasiswa'])->group(function () {
    Route::get('/dashboard', [NonDashboardController::class, 'index'])->name('non_mahasiswa.dashboard');

    Route::prefix('non_peminjaman')->group(function () {
        Route::get('/', [NonPeminjamanController::class, 'index'])->name('non_mahasiswa.peminjaman');
        Route::get('/tambah', [NonPeminjamanController::class, 'create'])->name('non_mahasiswa.peminjaman.create');
        Route::post('/', [NonPeminjamanController::class, 'store'])->name('non_mahasiswa.peminjaman.store');
        Route::get('/{id}/edit', [NonPeminjamanController::class, 'edit'])->name('non_mahasiswa.peminjaman.edit');
        Route::put('/{id}', [NonPeminjamanController::class, 'update'])->name('non_mahasiswa.peminjaman.update');
        Route::delete('/{id}', [NonPeminjamanController::class, 'destroy'])->name('non_mahasiswa.peminjaman.destroy');
    });

    Route::prefix('history')->group(function () {
        Route::get('/', [NonHistoryController::class, 'riwayat'])->name('non_mahasiswa.riwayat');
        Route::get('/{id}/detail', [NonHistoryController::class, 'detail'])->name('non_mahasiswa.riwayat.detail');
        Route::get('/{id}/print', [NonHistoryController::class, 'print'])->name('non_mahasiswa.riwayat.print');
        Route::delete('/{id}', [NonHistoryController::class, 'destroy'])->name('non_mahasiswa.riwayat.destroy');
    });

    Route::prefix('pembayaran')->group(function () {
        Route::get('/', [NonPembayaranController::class, 'index'])->name('non_mahasiswa.pembayaran');
        Route::get('/{id}', [BayarController::class, 'bayar'])->name('bayar');
        Route::post('/upload-bukti/{id}', [BayarController::class, 'uploadBukti'])->name('bayar.upload-bukti');
        Route::get('/download-qr/{id}', [BayarController::class, 'downloadQrCode'])->name('bayar.download-qr');
    });
});
