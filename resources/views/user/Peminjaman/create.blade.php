@extends('user.layouts.template')
@section('title', 'Form Peminjaman')

@section('contentUser')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Peminjaman /</span> Form Pengajuan
    </h4>

    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Form Pengajuan Peminjaman</h5>
                    <small class="text-muted float-end">Isi dengan lengkap</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mahasiswa.peminjaman.store') }}">
                        @csrf

                        <!-- Nama -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" disabled>
                            </div>
                        </div>

                        <!-- Fasilitas -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Fasilitas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control bg-light" value="{{ $fasilitas_pilih->nama_fasilitas }}" disabled>
                                <input type="hidden" name="fasilitas_id" value="{{ $fasilitas_pilih->id }}">
                            </div>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="row mb-3">
                            <label for="tanggal_mulai" class="col-sm-2 col-form-label">Tanggal Mulai</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="row mb-3">
                            <label for="tanggal_selesai" class="col-sm-2 col-form-label">Tanggal Selesai</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai" class="form-control" required>
                            </div>
                        </div>

                        <!-- Keperluan -->
                        <div class="row mb-3">
                            <label for="keperluan" class="col-sm-2 col-form-label">Keperluan</label>
                            <div class="col-sm-10">
                                <textarea name="keperluan" id="keperluan" rows="4" class="form-control" placeholder="Tuliskan keperluan peminjaman..." required></textarea>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row justify-content-end">
                            <div class="col-sm-10 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-send"></i> Ajukan
                                </button>
                                <a href="{{ route('mahasiswa.peminjaman') }}" class="btn btn-danger">
                                    <i class="bx bx-arrow-back"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
