@extends('user.layouts.template')
@section('title', 'Form Peminjaman')

@section('contentUser')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Form Pengajuan Peminjaman</h5>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bx bx-check-circle me-1"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-x-circle me-1"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('non_mahasiswa.peminjaman.store') }}" method="POST" novalidate>
                            @csrf

                            <!-- Nama -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                </div>
                            </div>

                            <!-- Fasilitas -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Fasilitas</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control mb-2"
                                        value="{{ $fasilitas_pilih->nama_fasilitas }}" disabled>
                                    <input type="hidden" name="fasilitas_id" value="{{ $fasilitas_pilih->id }}">
                                </div>
                            </div>

                            <!-- Biaya -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Biaya</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control mb-2"
                                        value="Rp {{ number_format($fasilitas_pilih->biaya, 0, ',', '.') }}" disabled>
                                    <input type="hidden" name="fasilitas_id" value="{{ $fasilitas_pilih->id }}">
                                </div>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div class="row mb-3">
                                <label for="tanggal_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        value="{{ old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Selesai -->
                            <div class="row mb-3">
                                <label for="tanggal_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai"
                                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        value="{{ old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Keperluan -->
                            <div class="row mb-3">
                                <label for="keperluan" class="col-sm-3 col-form-label">Keperluan</label>
                                <div class="col-sm-9">
                                    <textarea name="keperluan" id="keperluan" rows="4" class="form-control @error('keperluan') is-invalid @enderror">{{ old('keperluan') }}</textarea>
                                    @error('keperluan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row justify-content-end">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="bx bx-send me-1"></i> Ajukan
                                    </button>
                                    <a href="{{ route('non_mahasiswa.peminjaman') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-arrow-back me-1"></i> Kembali
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
