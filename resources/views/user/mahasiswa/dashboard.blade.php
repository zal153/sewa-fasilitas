@extends('user.layouts.template')

@section('title', 'Dashboard')
@section('contentUser')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->name }}! 🎉</h5>
                                <p class="mb-4">
                                    Selamat datang di sistem peminjaman fasilitas.
                                    Kelola peminjaman fasilitas Anda dengan mudah dan efisien.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('asset/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-4 order-1">
            <div class="row">

                <!-- Total Fasilitas -->
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0 bg-light-primary rounded">
                                    <i class="bx bx-building-house bx-sm text-primary"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('mahasiswa.peminjaman') }}">Lihat
                                            Fasilitas</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Fasilitas</span>
                            <h3 class="card-title mb-2">{{ $totalFasilitas }}</h3>
                            <small class="text-info fw-semibold">
                                <i class="bx bx-buildings"></i> Tersedia
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Peminjaman Aktif -->
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0 bg-light-success rounded">
                                    <i class="bx bx-calendar-check bx-sm text-success"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('riwayat') }}">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Peminjaman Aktif</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $peminjamanAktif }}</h3>
                            <small class="text-success fw-semibold">
                                <i class="bx bx-check-circle"></i> Sedang Berlangsung
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Menunggu Persetujuan -->
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0 bg-light-warning rounded">
                                    <i class="bx bx-time-five bx-sm text-warning"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('riwayat') }}">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block mb-1">Menunggu Persetujuan</span>
                            <h3 class="card-title text-nowrap mb-2">{{ $menungguPersetujuan }}</h3>
                            <small class="text-warning fw-semibold">
                                <i class="bx bx-time"></i> Pending
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Peminjaman -->
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0 bg-light-info rounded">
                                    <i class="bx bx-history bx-sm text-info"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="{{ route('riwayat') }}">Lihat Semua</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Riwayat Peminjaman</span>
                            <h3 class="card-title mb-2">{{ $riwayatPeminjaman }}</h3>
                            <small class="text-primary fw-semibold">
                                <i class="bx bx-history"></i> Total
                            </small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
