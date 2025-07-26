@extends('admin.layouts.admin')
@section('title', 'Jadwal')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .table-actions {
            white-space: nowrap;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }

        .card-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }

        .btn-refresh {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-calendar-alt"></i> Manajemen Jadwal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Jadwal</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Info Cards -->
                <div class="row mb-3">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $jadwal->count() }}</h3>
                                <p>Total Jadwal</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $jadwal->where('waktu_mulai', '>', now())->count() }}</h3>
                                <p>Jadwal Mendatang</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $jadwal->whereBetween('waktu_mulai', [now()->startOfDay(), now()->endOfDay()])->count() }}
                                </h3>
                                <p>Jadwal Hari Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $jadwal->where('waktu_selesai', '<', now())->count() }}</h3>
                                <p>Jadwal Selesai</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-list"></i> Daftar Jadwal Fasilitas
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

                            <div class="card-body">
                                <!-- Action Buttons -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-plus-circle"></i> Tambah Jadwal Baru
                                        </a>
                                        <button type="button" class="btn btn-success btn-lg" id="exportBtn">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-info btn-lg" id="refreshBtn">
                                            <i class="fas fa-sync-alt"></i> Refresh
                                        </button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary dropdown-toggle"
                                                data-toggle="dropdown">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" data-filter="all">Semua
                                                        Jadwal</a></li>
                                                <li><a class="dropdown-item" href="#" data-filter="today">Hari Ini</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        data-filter="upcoming">Mendatang</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        data-filter="finished">Selesai</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="jadwalTable" class="table table-bordered table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th width="20%">Fasilitas</th>
                                                <th width="18%">Waktu Mulai</th>
                                                <th width="18%">Waktu Selesai</th>
                                                <th width="12%">Status</th>
                                                <th width="10%">Durasi</th>
                                                <th width="17%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($jadwal as $item)
                                                @php
                                                    $now = now();
                                                    $status = '';
                                                    $statusClass = '';

                                                    if ($item->waktu_mulai > $now) {
                                                        $status = 'Mendatang';
                                                        $statusClass = 'badge-info';
                                                    } elseif (
                                                        $item->waktu_mulai <= $now &&
                                                        $item->waktu_selesai >= $now
                                                    ) {
                                                        $status = 'Berlangsung';
                                                        $statusClass = 'badge-success';
                                                    } else {
                                                        $status = 'Selesai';
                                                        $statusClass = 'badge-secondary';
                                                    }

                                                    $durasi = $item->waktu_mulai->diffInHours($item->waktu_selesai);
                                                @endphp
                                                <tr data-status="{{ strtolower($status) }}">
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>
                                                        <strong>{{ $item->fasilitas->nama_fasilitas ?? 'N/A' }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            {{ $item->fasilitas->lokasi ?? 'Lokasi tidak tersedia' }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-calendar-alt text-primary"></i>
                                                        {{ date('d M Y', strtotime($item->waktu_mulai)) }}
                                                        <br>
                                                        <i class="fas fa-clock text-success"></i>
                                                        {{ date('H:i', strtotime($item->waktu_mulai)) }} WIB
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-calendar-alt text-primary"></i>
                                                        {{ date('d M Y', strtotime($item->waktu_selesai)) }}
                                                        <br>
                                                        <i class="fas fa-clock text-danger"></i>
                                                        {{ date('H:i', strtotime($item->waktu_selesai)) }} WIB
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ $statusClass }} status-badge">
                                                            {{ $status }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge-light">
                                                            {{ $durasi }} jam
                                                        </span>
                                                    </td>
                                                    <td class="table-actions text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('jadwal.edit', $item->id) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                title="Edit Jadwal">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm delete-btn"
                                                                data-id="{{ $item->id }}"
                                                                data-nama="{{ $item->fasilitas->nama_fasilitas ?? 'N/A' }}"
                                                                data-toggle="tooltip" title="Hapus Jadwal">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-info btn-sm detail-btn"
                                                                data-toggle="modal" data-target="#detailModal"
                                                                data-id="{{ $item->id }}" title="Lihat Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        <div class="empty-state py-5">
                                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                            <h5 class="text-muted">Belum ada jadwal yang tersedia</h5>
                                                            <p class="text-muted">Silakan tambah jadwal baru dengan
                                                                mengklik tombol di atas</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if ($jadwal->count() > 0)
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="dataTables_info">
                                                Menampilkan {{ $jadwal->firstItem() }} sampai {{ $jadwal->lastItem() }}
                                                dari {{ $jadwal->total() }} entri
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="float-right">
                                                {{ $jadwal->links('pagination::bootstrap-4') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">
                        <i class="fas fa-info-circle"></i> Detail Jadwal
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#jadwalTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "ordering": true,
                "info": false,
                "paging": false,
                "searching": true,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "emptyTable": "Tidak ada data tersedia"
                }
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Refresh button animation
            $('#refreshBtn').click(function() {
                $(this).find('i').addClass('btn-refresh');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });

            // Filter functionality
            $('[data-filter]').click(function(e) {
                e.preventDefault();
                const filter = $(this).data('filter');
                const table = $('#jadwalTable').DataTable();

                if (filter === 'all') {
                    table.search('').draw();
                } else {
                    table.search(filter).draw();
                }
            });

            // Delete confirmation with SweetAlert
            $('.delete-btn').click(function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Yakin ingin menghapus jadwal untuk fasilitas "${nama}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create and submit delete form
                        const form = $('<form>', {
                            'method': 'POST',
                            'action': `/jadwal/${id}`
                        });
                        form.append($('<input>', {
                            'type': 'hidden',
                            'name': '_token',
                            'value': $('meta[name="csrf-token"]').attr('content')
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

            // Detail modal
            $('.detail-btn').click(function() {
                const id = $(this).data('id');
                $('#modalContent').html(
                    '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');

                // Simulate loading detail (replace with actual AJAX call)
                setTimeout(() => {
                    $('#modalContent').html(`
                <div class="row">
                    <div class="col-md-12">
                        <h5>Informasi Jadwal</h5>
                        <p>Detail jadwal akan ditampilkan di sini...</p>
                    </div>
                </div>
            `);
                }, 1000);
            });

            // Export functionality
            $('#exportBtn').click(function() {
                Swal.fire({
                    title: 'Export Data',
                    text: 'Fitur export akan segera tersedia',
                    icon: 'info'
                });
            });
        });
    </script>
@endpush
