@extends('admin.layouts.admin')
@section('title', 'Riwayat Pembayaran')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5.0.15/bootstrap-4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .status-badge {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }

        .action-buttons .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .table-actions {
            min-width: 200px;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .stats-card {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            border-radius: 10px;
        }

        .animate-number {
            font-size: 2rem;
            font-weight: bold;
            color: #28a745;
        }
    </style>
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-credit-card"></i> Manajemen Pembayaran</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pembayaran</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 class="animate-number">{{ $pembayaran->where('status', 'berhasil')->count() }}</h3>
                                <p>Pembayaran Berhasil</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 class="animate-number">{{ $pembayaran->where('status', 'menunggu')->count() }}</h3>
                                <p>Menunggu Pembayaran</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 class="animate-number">
                                    {{ $pembayaran->whereIn('status', ['gagal', 'kadaluarsa', 'dibatalkan'])->count() }}
                                </h3>
                                <p>Pembayaran Gagal</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 class="animate-number">
                                    Rp{{ number_format($pembayaran->where('status', 'berhasil')->sum('jumlah'), 0, ',', '.') }}
                                </h3>
                                <p>Total Pendapatan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter"></i> Filter & Pencarian</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <form method="GET" action="{{ route('pembayaran') }}" id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control select2">
                                            <option value="">-- Semua Status --</option>
                                            @foreach ($statusList as $status)
                                                <option value="{{ $status }}"
                                                    {{ request('status') == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="metode">Metode Pembayaran</label>
                                        <select name="metode" id="metode" class="form-control select2">
                                            <option value="">-- Semua Metode --</option>
                                            <option value="bank_transfer"
                                                {{ request('metode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                            </option>
                                            <option value="e_wallet"
                                                {{ request('metode') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                            <option value="credit_card"
                                                {{ request('metode') == 'credit_card' ? 'selected' : '' }}>Credit Card
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tanggal_dari">Tanggal Dari</label>
                                        <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control"
                                            value="{{ request('tanggal_dari') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tanggal_sampai">Tanggal Sampai</label>
                                        <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control"
                                            value="{{ request('tanggal_sampai') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <button type="button" class="btn btn-secondary" id="resetFilter">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                    <button type="button" class="btn btn-success" id="exportExcel">
                                        <i class="fas fa-file-excel"></i> Export Excel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Main Table Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-list"></i> Daftar Pembayaran</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip"
                                title="Refresh Data" onclick="location.reload()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pembayaranTable" class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Order ID</th>
                                        <th>Transaction ID</th>
                                        <th>Metode</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Peminjaman</th>
                                        <th width="15%" class="table-actions">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pembayaran as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $item->order_id }}</span>
                                            </td>
                                            <td>{{ $item->transaction_id ?? '-' }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-info">{{ strtoupper($item->metode ?? '-') }}</span>
                                            </td>
                                            <td class="font-weight-bold text-success">
                                                Rp{{ number_format($item->jumlah, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @php
                                                    $badge = match ($item->status) {
                                                        'berhasil' => 'success',
                                                        'menunggu' => 'warning',
                                                        'gagal', 'kadaluarsa', 'dibatalkan' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                    $icon = match ($item->status) {
                                                        'berhasil' => 'fa-check-circle',
                                                        'menunggu' => 'fa-clock',
                                                        'gagal', 'kadaluarsa', 'dibatalkan' => 'fa-times-circle',
                                                        default => 'fa-question-circle',
                                                    };
                                                @endphp
                                                <span class="badge badge-{{ $badge }} status-badge">
                                                    <i class="fas {{ $icon }}"></i> {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($item->tanggal_bayar)
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i>
                                                        {{ $item->tanggal_bayar->format('d/m/Y') }}<br>
                                                        <i class="fas fa-clock"></i>
                                                        {{ $item->tanggal_bayar->format('H:i') }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->peminjaman)
                                                    <span
                                                        class="badge badge-primary">{{ $item->peminjaman->kode_peminjaman }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="action-buttons">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-info btn-sm"
                                                        data-toggle="modal" data-target="#detailModal{{ $item->id }}"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="{{ route('pembayaran.print', $item->id) }}"
                                                        class="btn btn-primary btn-sm" target="_blank" title="Print">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                        data-id="{{ $item->id }}" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Tidak ada data pembayaran</h5>
                                                    <p class="text-muted">Belum ada transaksi pembayaran yang tercatat</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($pembayaran->total() > 0)
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div class="dataTables_info">
                                    Menampilkan {{ ($pembayaran->currentPage() - 1) * $pembayaran->perPage() + 1 }}
                                    sampai
                                    {{ min($pembayaran->currentPage() * $pembayaran->perPage(), $pembayaran->total()) }}
                                    dari total {{ $pembayaran->total() }} entri
                                </div>
                                <div class="dataTables_paginate">
                                    {{ $pembayaran->withQueryString()->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modals -->
    @foreach ($pembayaran as $item)
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-receipt"></i> Detail Pembayaran
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-hashtag"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Order ID</span>
                                        <span class="info-box-number">{{ $item->order_id }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-money-bill"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Jumlah</span>
                                        <span
                                            class="info-box-number">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <dl class="row">
                                            <dt class="col-sm-4">Transaction ID:</dt>
                                            <dd class="col-sm-8">{{ $item->transaction_id ?? '-' }}</dd>

                                            <dt class="col-sm-4">Metode Pembayaran:</dt>
                                            <dd class="col-sm-8">
                                                <span
                                                    class="badge badge-info">{{ strtoupper($item->metode ?? '-') }}</span>
                                            </dd>

                                            <dt class="col-sm-4">Status:</dt>
                                            <dd class="col-sm-8">
                                                @php
                                                    $badge = match ($item->status) {
                                                        'berhasil' => 'success',
                                                        'menunggu' => 'warning',
                                                        'gagal', 'kadaluarsa', 'dibatalkan' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span
                                                    class="badge badge-{{ $badge }}">{{ ucfirst($item->status) }}</span>
                                            </dd>

                                            <dt class="col-sm-4">Tanggal Bayar:</dt>
                                            <dd class="col-sm-8">
                                                {{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y H:i') : '-' }}
                                            </dd>

                                            <dt class="col-sm-4">Kode Peminjaman:</dt>
                                            <dd class="col-sm-8">
                                                @if ($item->peminjaman)
                                                    <span
                                                        class="badge badge-primary">{{ $item->peminjaman->kode_peminjaman }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('pembayaran.print', $item->id) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#pembayaranTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "paging": false,
                "language": {
                    "search": "Cari:",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(difilter dari _MAX_ total entri)"
                }
            });

            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Reset Filter
            $('#resetFilter').click(function() {
                window.location.href = '{{ route('pembayaran') }}';
            });

            // Delete functionality with SweetAlert
            $('.delete-btn').click(function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus data pembayaran ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create and submit form
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '{{ route('pembayaran.destroy', ':id') }}'.replace(
                                ':id', id)
                        });

                        form.append($('<input>', {
                            'type': 'hidden',
                            'name': '_token',
                            'value': '{{ csrf_token() }}'
                        }));

                        form.append($('<input>', {
                            'type': 'hidden',
                            'name': '_method',
                            'value': 'DELETE'
                        }));

                        $('body').append(form);
                        form.submit();
                    }
                });
            });

            // Export Excel
            $('#exportExcel').click(function() {
                var params = new URLSearchParams(window.location.search);
                params.append('export', 'excel');
                window.location.href = '{{ route('pembayaran') }}?' + params.toString();
            });

            // Auto refresh every 30 seconds
            setInterval(function() {
                if (!$('.modal').hasClass('show')) {
                    location.reload();
                }
            }, 30000);

            // Success/Error Messages
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}');
            @endif

            // Animate numbers on page load
            $('.animate-number').each(function() {
                var $this = $(this);
                var countTo = $this.text().replace(/[^\d]/g, '');

                $({
                    countNum: 0
                }).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'linear',
                    step: function() {
                        var num = Math.floor(this.countNum);
                        if ($this.text().includes('Rp')) {
                            $this.text('Rp' + num.toLocaleString('id-ID'));
                        } else {
                            $this.text(num.toLocaleString('id-ID'));
                        }
                    },
                    complete: function() {
                        if ($this.text().includes('Rp')) {
                            $this.text('Rp' + parseInt(countTo).toLocaleString('id-ID'));
                        } else {
                            $this.text(parseInt(countTo).toLocaleString('id-ID'));
                        }
                    }
                });
            });
        });
    </script>
@endpush
