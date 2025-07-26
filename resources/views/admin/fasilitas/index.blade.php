@extends('admin.layouts.admin')
@section('title', 'Fasilitas')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .facility-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .facility-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .facility-image {
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .facility-image:hover {
            transform: scale(1.1);
        }

        .stats-card {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .search-box {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
        }
    </style>
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <i class="fas fa-building text-primary"></i>
                            Manajemen Fasilitas
                        </h1>
                        <p class="text-muted">Kelola data fasilitas dengan mudah</p>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Fasilitas</li>
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
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $allFasilitas->count() }}</h3>
                                <p>Total Fasilitas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $allFasilitas->where('status_penggunaan', 'digunakan')->count() }}</h3>
                                <p>Sedang Digunakan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $allFasilitas->where('status_penggunaan', 'tidak_digunakan')->count() }}</h3>
                                <p>Tersedia</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>Rp {{ number_format($allFasilitas->avg('biaya'), 0, ',', '.') }}</h3>
                                <p>Rata-rata Biaya</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="statusFilter">Filter Status:</label>
                                <select class="form-control" id="statusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="digunakan">Digunakan</option>
                                    <option value="tidak_digunakan">Tidak Digunakan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lokasiFilter">Filter Lokasi:</label>
                                <select class="form-control" id="lokasiFilter">
                                    <option value="">Semua Lokasi</option>
                                    @foreach ($allFasilitas->pluck('lokasi')->unique() as $lokasi)
                                        <option value="{{ $lokasi }}">{{ $lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="searchInput">Pencarian:</label>
                                <input type="text" class="form-control search-box" id="searchInput"
                                    placeholder="Cari fasilitas...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card facility-card">
                            <div class="card-header bg-gradient-primary">
                                <h3 class="card-title text-white">
                                    <i class="fas fa-list"></i>
                                    Daftar Fasilitas
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ route('fasilitas.create') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Tambah Fasilitas
                                    </a>
                                    <button type="button" class="btn btn-info btn-sm ml-2" onclick="refreshData()">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                    <button class="btn btn-secondary btn-sm ml-2" onclick="toggleView()">
                                        <i class="fas fa-th" id="viewToggleIcon"></i>
                                        <span id="viewToggleText">Grid View</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Table View -->
                            <div class="card-body table-responsive p-0" id="tableView">
                                <table class="table table-hover table-striped" id="fasilitasTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th width="15%">Fasilitas</th>
                                            <th width="10%">Gambar</th>
                                            <th width="20%">Deskripsi</th>
                                            <th width="10%">Lokasi</th>
                                            <th width="12%">Biaya</th>
                                            <th width="8%">Kapasitas</th>
                                            <th width="10%">Status</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($fasilitas as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>
                                                    <strong>{{ $item->nama_fasilitas }}</strong>
                                                    <br>
                                                    <small class="text-muted">ID: #{{ $item->id }}</small>
                                                </td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar"
                                                        class="facility-image" width="60" height="60"
                                                        style="object-fit: cover; cursor: pointer;"
                                                        onclick="showImageModal('{{ asset('storage/' . $item->gambar) }}', '{{ $item->nama_fasilitas }}')">
                                                </td>
                                                <td>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                                        title="{{ $item->deskripsi }}">
                                                        {{ Str::limit($item->deskripsi, 50) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                                    {{ $item->lokasi }}
                                                </td>
                                                <td>
                                                    <strong class="text-success">
                                                        Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                                    </strong>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-users"></i>
                                                        {{ $item->kapasitas }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($item->status_penggunaan === 'digunakan')
                                                        <span class="badge badge-success status-badge">
                                                            <i class="fas fa-check"></i> Digunakan
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning status-badge">
                                                            <i class="fas fa-clock"></i> Tersedia
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('fasilitas.edit', $item->id) }}"
                                                            class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            title="Hapus"
                                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_fasilitas }}')">
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
                                                        <h5 class="text-muted">Tidak ada data fasilitas</h5>
                                                        <p class="text-muted">Silakan tambah fasilitas baru</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Grid View -->
                            <div class="card-body d-none" id="gridView">
                                <div class="row" id="facilitiesGrid">
                                    @forelse ($fasilitas as $item)
                                        <div class="col-md-6 col-lg-4 mb-4 facility-item"
                                            data-status="{{ $item->status_penggunaan }}"
                                            data-lokasi="{{ $item->lokasi }}"
                                            data-nama="{{ strtolower($item->nama_fasilitas) }}">
                                            <div class="card h-100 facility-card">
                                                <div class="card-img-top position-relative"
                                                    style="height: 200px; overflow: hidden;">
                                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                                        class="w-100 h-100" style="object-fit: cover;"
                                                        onclick="showImageModal('{{ asset('storage/' . $item->gambar) }}', '{{ $item->nama_fasilitas }}')">
                                                    <div class="position-absolute" style="top: 10px; right: 10px;">
                                                        @if ($item->status_penggunaan === 'digunakan')
                                                            <span class="badge badge-success status-badge">
                                                                <i class="fas fa-check"></i> Digunakan
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning status-badge">
                                                                <i class="fas fa-clock"></i> Tersedia
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title">{{ $item->nama_fasilitas }}</h5>
                                                    <p class="card-text text-muted small flex-grow-1">
                                                        {{ Str::limit($item->deskripsi, 80) }}
                                                    </p>
                                                    <div class="mt-auto">
                                                        <div class="row text-center mb-3">
                                                            <div class="col-4">
                                                                <small class="text-muted">Lokasi</small>
                                                                <br>
                                                                <strong>{{ $item->lokasi }}</strong>
                                                            </div>
                                                            <div class="col-4">
                                                                <small class="text-muted">Kapasitas</small>
                                                                <br>
                                                                <strong>{{ $item->kapasitas }}</strong>
                                                            </div>
                                                            <div class="col-4">
                                                                <small class="text-muted">Biaya</small>
                                                                <br>
                                                                <strong class="text-success">
                                                                    Rp {{ number_format($item->biaya / 1000, 0) }}K
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <div class="action-buttons justify-content-center">
                                                            <a href="{{ route('fasilitas.edit', $item->id) }}"
                                                                class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_fasilitas }}')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="text-center py-5">
                                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                                <h4 class="text-muted">Tidak ada data fasilitas</h4>
                                                <p class="text-muted">Silakan tambah fasilitas baru</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Pagination -->
                            @if ($fasilitas->hasPages())
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <p class="text-muted mb-0">
                                                Menampilkan {{ $fasilitas->firstItem() }} sampai
                                                {{ $fasilitas->lastItem() }}
                                                dari {{ $fasilitas->total() }} data
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="float-right">
                                                {{ $fasilitas->links('pagination::bootstrap-4') }}
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

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalTitle">Preview Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Preview">
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#fasilitasTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                columnDefs: [{
                    orderable: false,
                    targets: [2, 8]
                }]
            });

            // Custom filtering
            $('#statusFilter, #lokasiFilter').on('change', function() {
                filterData();
            });

            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
                if (!$('#gridView').hasClass('d-none')) {
                    filterGridItems();
                }
            });

            function filterData() {
                var status = $('#statusFilter').val();
                var lokasi = $('#lokasiFilter').val();

                table.columns(7).search(status).draw();
                table.columns(4).search(lokasi).draw();

                if (!$('#gridView').hasClass('d-none')) {
                    filterGridItems();
                }
            }

            function filterGridItems() {
                var status = $('#statusFilter').val();
                var lokasi = $('#lokasiFilter').val();
                var search = $('#searchInput').val().toLowerCase();

                $('.facility-item').each(function() {
                    var item = $(this);
                    var itemStatus = item.data('status');
                    var itemLokasi = item.data('lokasi');
                    var itemNama = item.data('nama');

                    var statusMatch = !status || itemStatus === status;
                    var lokasiMatch = !lokasi || itemLokasi === lokasi;
                    var searchMatch = !search || itemNama.includes(search);

                    if (statusMatch && lokasiMatch && searchMatch) {
                        item.show();
                    } else {
                        item.hide();
                    }
                });
            }
        });

        // Toggle between table and grid view
        function toggleView() {
            var tableView = $('#tableView');
            var gridView = $('#gridView');
            var icon = $('#viewToggleIcon');
            var text = $('#viewToggleText');

            if (!tableView.hasClass('d-none')) {
                tableView.addClass('d-none');
                gridView.removeClass('d-none');
                icon.removeClass('fa-th').addClass('fa-table');
                text.text('Table View');
            } else {
                gridView.addClass('d-none');
                tableView.removeClass('d-none');
                icon.removeClass('fa-table').addClass('fa-th');
                text.text('Grid View');
            }
        }

        // Show image modal
        function showImageModal(imageSrc, title) {
            $('#modalImage').attr('src', imageSrc);
            $('#imageModalTitle').text(title);
            $('#imageModal').modal('show');
        }

        // Confirm delete with SweetAlert
        function confirmDelete(id, nama) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus fasilitas "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#deleteForm');
                    form.attr('action', `{{ route('fasilitas.destroy', 'id') }}/${id}`);
                    form.submit();
                }
            });
        }

        // Refresh data
        function refreshData() {
            Swal.fire({
                title: 'Refresh Data',
                text: 'Sedang memuat ulang data...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                location.reload();
            }, 1000);
        }

        // Success/Error messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush
