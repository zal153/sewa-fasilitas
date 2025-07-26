@extends('admin.layouts.admin')
@section('title', 'Data Peminjaman')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5.0.15/bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-history"></i> Data Peminjaman</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Peminjaman</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Filter & Search Card -->
                <div class="card card-outline card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter"></i> Filter & Pencarian</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control select2" id="filterStatus">
                                            <option value="">Semua Status</option>
                                            <option value="Menunggu"
                                                {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="Diproses"
                                                {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="Disetujui"
                                                {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>
                                                Ditolak</option>
                                            <option value="Batal" {{ request('status') == 'Batal' ? 'selected' : '' }}>
                                                Batal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tanggal Mulai</label>
                                        <input type="date" name="tanggal_mulai" class="form-control"
                                            value="{{ request('tanggal_mulai') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tanggal Selesai</label>
                                        <input type="date" name="tanggal_selesai" class="form-control"
                                            value="{{ request('tanggal_selesai') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary mr-2">
                                                <i class="fas fa-search"></i> Filter
                                            </button>
                                            <a href="{{ route('riwayat') }}" class="btn btn-secondary">
                                                <i class="fas fa-undo"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-3">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $stats['total'] ?? 0 }}</h3>
                                <p>Total Peminjaman</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $stats['menunggu'] ?? 0 }}</h3>
                                <p>Menunggu Persetujuan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $stats['disetujui'] ?? 0 }}</h3>
                                <p>Disetujui</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $stats['ditolak'] ?? 0 }}</h3>
                                <p>Ditolak</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Data Table -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-table"></i> Daftar Peminjaman</h3>
                        <div class="card-tools">
                            {{-- <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-download"></i> Export
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('riwayat.export', 'excel') }}">
                                        <i class="fas fa-file-excel text-success"></i> Excel
                                    </a>
                                    <a class="dropdown-item" href="{{ route('riwayat.export', 'pdf') }}">
                                        <i class="fas fa-file-pdf text-danger"></i> PDF
                                    </a>
                                </div>
                            </div> --}}
                            <button type="button" class="btn btn-tool" onclick="location.reload()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="peminjamanTable" class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">No.</th>
                                        <th>Kode</th>
                                        <th>Peminjam</th>
                                        <th>Fasilitas</th>
                                        <th>Waktu Peminjaman</th>
                                        <th>Keperluan</th>
                                        <th>Status</th>
                                        @if ($adaNonMahasiswa)
                                            <th>Pembayaran</th>
                                        @endif
                                        <th>Disetujui</th>
                                        <th width="12%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayat as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-outline-primary">{{ $item->kode_peminjaman }}</span>
                                            </td>
                                            <td>
                                                <div class="user-panel d-flex">
                                                    <div class="image">
                                                        <img src="{{ $item->user->avatar ?? asset('dist/img/user2-160x160.jpg') }}"
                                                            class="img-circle elevation-2" alt="User Image"
                                                            style="width: 25px; height: 25px;">
                                                    </div>
                                                    <div class="info">
                                                        <span>{{ $item->user->name ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="fas fa-building text-primary"></i>
                                                {{ $item->fasilitas->nama_fasilitas ?? '-' }}
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ $item->tanggal_mulai->format('d/m/Y H:i') }}<br>
                                                    <i class="fas fa-arrow-right"></i>
                                                    {{ $item->tanggal_selesai->format('d/m/Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 150px;"
                                                    title="{{ $item->keperluan }}">
                                                    {{ $item->keperluan }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $status = $item->status ?? 'Menunggu';
                                                    $badgeClass = match ($status) {
                                                        'Diproses' => 'badge badge-warning',
                                                        'Disetujui' => 'badge badge-success',
                                                        'Ditolak' => 'badge badge-danger',
                                                        'Menunggu' => 'badge badge-info',
                                                        'Batal' => 'badge badge-secondary',
                                                        default => 'badge badge-info',
                                                    };
                                                @endphp
                                                <span class="{{ $badgeClass }}">
                                                    <i class="fas fa-circle mr-1" style="font-size: 8px;"></i>
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            @if ($adaNonMahasiswa)
                                                <td>
                                                    <span
                                                        class="badge {{ $item->is_aktif ? 'badge-danger' : 'badge-success' }}">
                                                        <i
                                                            class="fas {{ $item->is_aktif ? 'fa-times' : 'fa-check' }} mr-1"></i>
                                                        {{ $item->is_aktif ? 'Belum Bayar' : 'Sudah Bayar' }}
                                                    </span>
                                                </td>
                                            @endif
                                            <td>
                                                @if ($item->approvedBy)
                                                    <small class="text-success">
                                                        <i class="fas fa-user-check"></i>
                                                        {{ $item->approvedBy->name }}
                                                    </small>
                                                @else
                                                    <small class="text-muted">-</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-info btn-detail"
                                                        data-id="{{ $item->id }}" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="{{ route('riwayat.print', $item->id) }}" target="_blank"
                                                        class="btn btn-warning" title="Print">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-delete"
                                                        data-id="{{ $item->id }}"
                                                        data-kode="{{ $item->kode_peminjaman }}" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $adaNonMahasiswa ? '10' : '9' }}"
                                                class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                                <h5>Belum ada data peminjaman</h5>
                                                <p>Data peminjaman akan muncul di sini</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if (method_exists($riwayat, 'hasPages') && $riwayat->hasPages())
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    @php
                                        $start = ($riwayat->currentPage() - 1) * $riwayat->perPage() + 1;
                                        $end = min($riwayat->currentPage() * $riwayat->perPage(), $riwayat->total());
                                    @endphp
                                    <small class="text-muted">
                                        Menampilkan {{ $start }} sampai {{ $end }} dari
                                        {{ $riwayat->total() }} data
                                    </small>
                                </div>
                                <div class="col-sm-6">
                                    <div class="float-right">
                                        {{ $riwayat->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(method_exists($riwayat, 'count'))
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-sm-12">
                                    <small class="text-muted">
                                        Total {{ $riwayat->count() }} data peminjaman
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">
                        <i class="fas fa-info-circle"></i> Detail Peminjaman
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalDetailContent">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p>Memuat data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#peminjamanTable').DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: false,
                paging: false,
                info: false,
                order: [
                    [0, 'desc']
                ]
            });

            // Detail Modal
            $('.btn-detail').click(function() {
                const id = $(this).data('id');

                $('#modalDetail').modal('show');
                $('#modalDetailContent').html(`
            <div class="text-center">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p>Memuat data...</p>
            </div>
        `);

                $.get(`{{ route('riwayat.detail', ':id') }}/${id}`)
                    .done(function(data) {
                        $('#modalDetailContent').html(data);
                    })
                    .fail(function() {
                        $('#modalDetailContent').html(`
                    <div class="text-center text-danger">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                        <p>Gagal memuat data</p>
                    </div>
                `);
                    });
            });

            // Delete Confirmation
            $('.btn-delete').click(function() {
                const id = $(this).data('id');
                const kode = $(this).data('kode');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Yakin ingin menghapus peminjaman ${kode}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                    cancelButtonText: '<i class="fas fa-times"></i> Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create and submit form
                        const form = $(`
                    <form action="{{ route('peminjaman.destroy', ':id') }}/${id}" method="POST">
                        @csrf
                        @extends('admin.layouts.admin')
                    </form>
                `);
                        $('body').append(form);
                        form.submit();
                    }
                });
            });

            // Toastr Configuration
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            // Show success message if exists
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            // Show error message if exists
            @if (session('error'))
                toastr.error('{{ session('error') }}');
            @endif
        });
    </script>
@endpush
