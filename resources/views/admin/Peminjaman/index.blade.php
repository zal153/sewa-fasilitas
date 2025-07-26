@extends('admin.layouts.admin')
@section('title', 'Data Peminjaman')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.6/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs4@2.5.0/css/responsive.bootstrap4.min.css">

    <style>
        .status-badge {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .btn-action {
            margin: 2px;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .search-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .stats-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <!-- Stats Cards -->
                <div class="row mb-3">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="totalPeminjaman">{{ $peminjaman->count() }}</h3>
                                <p>Total Peminjaman</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 id="disetujui">{{ $peminjaman->where('status', 'disetujui')->count() }}</h3>
                                <p>Disetujui</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 id="pending">{{ $peminjaman->where('status', 'diajukan')->count() }}</h3>
                                <p>Menunggu Persetujuan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 id="ditolak">{{ $peminjaman->where('status', 'ditolak')->count() }}</h3>
                                <p>Ditolak</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter Card -->
                <div class="card search-container text-white">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-inline" id="searchForm">
                                <div class="input-group input-group-sm mr-3" style="width: 250px;">
                                    <input type="text" name="search" id="searchInput" class="form-control"
                                        placeholder="Cari nama, kode, atau fasilitas..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-light">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <select name="status" id="statusFilter" class="form-control form-control-sm mr-3">
                                    <option value="">Semua Status</option>
                                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>
                                        Diajukan</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                </select>
                                <input type="date" name="tanggal" id="dateFilter"
                                    class="form-control form-control-sm mr-3" value="{{ request('tanggal') }}">
                            </form>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="btn btn-light btn-sm" id="refreshBtn">
                                <i class="fas fa-sync-alt spin-on-hover"></i> Refresh
                            </button>
                            <button type="button" class="btn btn-success btn-sm" id="exportBtn">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Table Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-table mr-2"></i>
                            Data Peminjaman Fasilitas
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: 600px;">
                        <div id="loadingSpinner" class="text-center p-3" style="display: none;">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                            <p>Memuat data...</p>
                        </div>

                        <table class="table table-bordered table-head-fixed text-nowrap" id="peminjamanTable">
                            <thead>
                                <tr>
                                    <th width="50">No.</th>
                                    <th>Kode Peminjaman</th>
                                    <th>Nama Peminjam</th>
                                    <th>Fasilitas</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Keperluan</th>
                                    <th width="100">Status</th>
                                    @if ($adaNonMahasiswa)
                                        <th>Biaya</th>
                                        <th>Pembayaran</th>
                                    @endif
                                    <th>Disetujui Oleh</th>
                                    <th>Catatan</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjaman as $item)
                                    <tr data-id="{{ $item->id }}" class="fade-in">
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $item->kode_peminjaman }}</span>
                                        </td>
                                        <td>
                                            <div class="user-panel d-inline-flex">
                                                <div class="image">
                                                    <img src="{{ asset('dist/img/user.png') }}"
                                                        class="img-circle elevation-1" alt="User Image"
                                                        style="width: 30px; height: 30px;">
                                                </div>
                                                <div class="info ml-2">
                                                    <strong>{{ $item->user->name ?? '_' }}</strong><br>
                                                    <small class="text-muted">{{ $item->user->role ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-building text-primary mr-1"></i>
                                            {{ $item->fasilitas->nama_fasilitas ?? '_' }}
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar-alt text-success mr-1"></i>
                                            {{ $item->tanggal_mulai->format('d M Y H:i') }}
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar-check text-danger mr-1"></i>
                                            {{ $item->tanggal_selesai->format('d M Y H:i') }}
                                        </td>
                                        <td>
                                            <span class="text-truncate" style="max-width: 150px;"
                                                title="{{ $item->keperluan }}">
                                                {{ Str::limit($item->keperluan, 30) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $status = $item->status ?? 'diajukan';
                                                $badgeClass = match ($status) {
                                                    'disetujui' => 'badge badge-success status-badge',
                                                    'ditolak' => 'badge badge-danger status-badge',
                                                    'diajukan' => 'badge badge-warning status-badge',
                                                    'selesai' => 'badge badge-secondary status-badge',
                                                    default => 'badge badge-info status-badge',
                                                };
                                            @endphp
                                            <span class="{{ $badgeClass }}" data-toggle="tooltip"
                                                title="Status: {{ ucfirst($status) }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        @if ($adaNonMahasiswa)
                                            <td>
                                                @if ($item->user->role === 'non-mahasiswa')
                                                    <span class="badge badge-primary">
                                                        Rp {{ number_format($item->biaya ?? 0, 0, ',', '.') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->user->role === 'non-mahasiswa')
                                                    <span
                                                        class="badge {{ $item->is_bayar ? 'badge-success' : 'badge-danger' }}">
                                                        <i
                                                            class="fas {{ $item->is_bayar ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                                        {{ $item->is_bayar ? 'Sudah Bayar' : 'Belum Bayar' }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td>{{ $item->approvedBy->name ?? '-' }}</td>
                                        <td>
                                            <span class="text-truncate" style="max-width: 100px;"
                                                title="{{ $item->catatan }}">
                                                {{ $item->catatan ? Str::limit($item->catatan, 20) : '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('peminjaman.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning btn-action" data-toggle="tooltip"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                @if ($item->status == 'diajukan')
                                                    <button type="button"
                                                        class="btn btn-sm btn-success btn-action approve-btn"
                                                        data-id="{{ $item->id }}" data-toggle="tooltip"
                                                        title="Setujui" {{ empty($item->catatan) ? 'disabled' : '' }}>
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger btn-action reject-btn"
                                                        data-id="{{ $item->id }}" data-toggle="tooltip"
                                                        title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif

                                                <button type="button" class="btn btn-sm btn-danger btn-action delete-btn"
                                                    data-id="{{ $item->id }}" data-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada data peminjaman</h5>
                                            <p class="text-muted">Data akan muncul setelah ada peminjaman baru</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-left">
                            @if ($peminjaman->count() > 0)
                                @php
                                    $start = ($data->currentPage() - 1) * $data->perPage() + 1;
                                    $end = min($data->currentPage() * $data->perPage(), $data->total());
                                @endphp
                                <p class="text-sm text-muted">
                                    Menampilkan {{ $start }} sampai {{ $end }} dari {{ $data->total() }}
                                    data
                                </p>
                            @endif
                        </div>
                        <div class="float-right">
                            {{ $data->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Auto search
            let searchTimeout;
            $('#searchInput, #statusFilter, #dateFilter').on('input change', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    $('#searchForm').submit();
                }, 500);
            });

            // Refresh button
            $('#refreshBtn').click(function() {
                $(this).find('i').addClass('fa-spin');
                location.reload();
            });

            // Approve button
            $('.approve-btn').click(function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Setujui Peminjaman?',
                    text: 'Peminjaman akan disetujui dan tidak dapat dibatalkan',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Memproses...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        $.ajax({
                            url: `/peminjaman/${id}/approve`,
                            method: 'PATCH',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Peminjaman telah disetujui',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat memproses data',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            // Delete button
            $('.delete-btn').click(function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'Data yang dihapus tidak dapat dikembalikan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit delete form
                        const form = $('<form>', {
                            'method': 'POST',
                            'action': `/peminjaman/${id}`
                        }).append(
                            $('<input>', {
                                'type': 'hidden',
                                'name': '_token',
                                'value': $('meta[name="csrf-token"]').attr('content')
                            }),
                            $('<input>', {
                                'type': 'hidden',
                                'name': '_method',
                                'value': 'DELETE'
                            })
                        );

                        $('body').append(form);
                        form.submit();
                    }
                });
            });

            // Export button
            $('#exportBtn').click(function() {
                Swal.fire({
                    title: 'Pilih Format Export',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Excel',
                    denyButtonText: 'PDF',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/peminjaman/export/excel';
                    } else if (result.isDenied) {
                        window.location.href = '/peminjaman/export/pdf';
                    }
                });
            });

            // Fade in animation for table rows
            $('.fade-in').each(function(index) {
                $(this).delay(index * 100).fadeIn();
            });
        });
    </script>
@endpush
