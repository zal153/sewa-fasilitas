<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Users roles
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nip')->nullable();
            $table->string('jabatan');
            $table->string('kontak');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nidn')->unique();
            $table->string('fakultas');
            $table->string('jurusan');
            $table->string('kontak');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nim')->unique();
            $table->string('fakultas');
            $table->string('jurusan');
            $table->string('angkatan');
            $table->string('kontak');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('non_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('institusi');
            $table->string('jabatan')->nullable();
            $table->string('identitas_no')->unique();
            $table->string('alamat');
            $table->string('kontak');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nip')->nullable();
            $table->string('departemen');
            $table->string('jabatan');
            $table->boolean('can_approve')->default(false);
            $table->string('kontak');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Fasilitas Kampus
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fasilitas');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi');
            $table->decimal('biaya', 10, 2)->nullable();
            $table->integer('kapasitas')->nullable();
            $table->string('gambar')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('jadwal_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fasilitas_id');
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_selesai');
            $table->timestamps();

            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');
        });

        Schema::create('peminjaman_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('fasilitas_id');
            $table->datetime('tanggal_mulai');
            $table->datetime('tanggal_selesai');
            $table->text('keperluan')->nullable();
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak', 'selesai'])->default('diajukan');
            $table->decimal('biaya', 10, 2)->nullable();
            $table->boolean('is_bayar')->default(false);
            $table->unsignedBigInteger('disetujui_oleh')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');
            $table->foreign('disetujui_oleh')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('pembayaran_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id');
            $table->string('order_id')->unique();
            $table->string('transaction_id')->nullable();
            $table->enum('metode', ['gopay', 'qris', 'transfer_bank', 'kartu_kredit'])->nullable();
            $table->decimal('jumlah', 10, 2);
            $table->enum('status', ['menunggu', 'berhasil', 'dibatalkan', 'kadaluarsa', 'gagal'])->default('menunggu');
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->foreign('peminjaman_id')->references('id')->on('peminjaman_fasilitas')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('pembayaran_fasilitas');
        Schema::dropIfExists('peminjaman_fasilitas');
        Schema::dropIfExists('jadwal_fasilitas');
        Schema::dropIfExists('fasilitas');
        Schema::dropIfExists('non_mahasiswa');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('dosen');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('users');
    }
};
