@extends('user.layouts.template')
@section('title', 'Pengajuan Peminjaman Fasilitas')

@push('styles')
    <style>
        .facility-item:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
        }

        .facility-item:hover img {
            transform: scale(1.05);
        }

        .facility-item:hover .hover-overlay {
            opacity: 1 !important;
        }

        .bg-gradient-dark {
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.8) 100%);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .badge {
            font-size: 0.75rem;
        }

        .card-body .bg-light {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 768px) {
            .facility-item:hover {
                transform: none;
            }

            .display-6 {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@section('contentUser')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white overflow-hidden"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body py-5">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="display-6 text-white fw-bold mb-3">Peminjaman Fasilitas</h1>
                                <p class="lead mb-2">Temukan dan ajukan peminjaman fasilitas yang Anda butuhkan dengan mudah
                                    dan cepat.</p>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-info-circle me-2"></i>
                                    <small class="opacity-75">Khusus untuk masyarakat umum - Biaya berlaku sesuai
                                        ketentuan</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-end d-none d-md-block">
                                <i class="bx bx-buildings" style="font-size: 120px; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search-facility" class="form-label fw-semibold">
                                    <i class="bx bx-search me-1"></i>Cari Fasilitas
                                </label>
                                <input type="search" id="search-facility" class="form-control form-control-lg"
                                    placeholder="Ketik nama fasilitas...">
                            </div>
                            <div class="col-md-3">
                                <label for="filter-status" class="form-label fw-semibold">
                                    <i class="bx bx-filter me-1"></i>Status
                                </label>
                                <select id="filter-status" class="form-select form-select-lg">
                                    <option value="">Semua Status</option>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="tidak-tersedia">Tidak Tersedia</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="filter-price" class="form-label fw-semibold">
                                    <i class="bx bx-money me-1"></i>Harga
                                </label>
                                <select id="filter-price" class="form-select form-select-lg">
                                    <option value="">Semua Harga</option>
                                    <option value="0-100000">
                                        < Rp 100rb</option>
                                    <option value="100000-500000">Rp 100rb - 500rb</option>
                                    <option value="500000-1000000">Rp 500rb - 1jt</option>
                                    <option value="1000000-999999999">> Rp 1jt</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="sort-by" class="form-label fw-semibold">
                                    <i class="bx bx-sort me-1"></i>Urutkan
                                </label>
                                <select id="sort-by" class="form-select form-select-lg">
                                    <option value="nama">Nama A-Z</option>
                                    <option value="biaya-rendah">Biaya Terendah</option>
                                    <option value="biaya-tinggi">Biaya Tertinggi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row g-3 h-100">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                            <div class="card-body text-center">
                                <i class="bx bx-building-house fs-1 mb-2"></i>
                                <h6 class="mb-1">Total Fasilitas</h6>
                                <h4 class="mb-0 fw-bold">{{ $fasilitas->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm h-100 bg-success text-white">
                            <div class="card-body text-center">
                                <i class="bx bx-check-circle fs-1 mb-2"></i>
                                <h6 class="mb-1">Tersedia</h6>
                                <h4 class="mb-0 fw-bold">{{ $fasilitas->where('kondisi', 'true')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bx bx-x-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Price Range Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info border-0" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-info-circle me-3 fs-4"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Informasi Biaya Peminjaman</h6>
                            <p class="mb-0 small">
                                Biaya peminjaman bervariasi tergantung jenis fasilitas.
                                Rentang harga: <strong>Rp
                                    {{ number_format($fasilitas->min('biaya'), 0, ',', '.') }}</strong> -
                                <strong>Rp {{ number_format($fasilitas->max('biaya'), 0, ',', '.') }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading-state" class="text-center py-5 d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat fasilitas...</p>
        </div>

        <!-- Facilities Grid -->
        <div class="row" id="facility-list">
            @forelse ($fasilitas as $item)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 facility-card"
                    data-name="{{ strtolower($item->nama_fasilitas) }}"
                    data-status="{{ $item->kondisi == 'true' ? 'tersedia' : 'tidak-tersedia' }}"
                    data-biaya="{{ $item->biaya }}">
                    <div class="card h-100 shadow-sm border-0 facility-item position-relative">

                        <!-- Price Badge -->
                        <div class="position-absolute top-0 end-0 m-3" style="z-index: 2;">
                            <span class="badge bg-warning text-dark fw-bold px-3 py-2">
                                Rp {{ number_format($item->biaya, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Image Container with Overlay -->
                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top w-100 h-100"
                                alt="{{ $item->nama_fasilitas }}"
                                style="object-fit: cover; transition: transform 0.3s ease;">

                            <!-- Status Badge -->
                            <div class="position-absolute top-0 start-0 m-3">
                                @if ($item->kondisi == 'true')
                                    <span class="badge bg-success">
                                        <i class="bx bx-check-circle me-1"></i>Tersedia
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bx bx-x-circle me-1"></i>Sedang Digunakan
                                    </span>
                                @endif
                            </div>

                            <!-- Quick View Button -->
                            <div class="position-absolute bottom-0 end-0 m-3">
                                <button class="btn btn-sm btn-light rounded-circle shadow" data-bs-toggle="modal"
                                    data-bs-target="#quickViewModal{{ $item->id }}" title="Lihat Detail">
                                    <i class="bx bx-show"></i>
                                </button>
                            </div>

                            <!-- Hover Overlay -->
                            <div class="position-absolute bottom-0 start-0 end-0 bg-gradient-dark p-3 text-white opacity-0 hover-overlay"
                                style="transition: opacity 0.3s ease;">
                                <small class="d-block">{{ Str::limit($item->deskripsi, 60) }}</small>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2">{{ $item->nama_fasilitas }}</h5>

                            <!-- Price Highlight -->
                            <div class="mb-3 p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Biaya Peminjaman</span>
                                    <div class="text-end">
                                        <div class="h5 text-primary fw-bold mb-0">
                                            Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                        </div>
                                        <small class="text-muted">per hari</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Short Description -->
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($item->deskripsi, 80) }}
                            </p>

                            <!-- Action Button -->
                            <div class="mt-auto">
                                @if ($item->kondisi == 'true')
                                    <a href="{{ route('non_mahasiswa.peminjaman.create', ['fasilitas_id' => $item->id]) }}"
                                        class="btn btn-primary w-100 btn-lg">
                                        <i class="bx bx-calendar-plus me-2"></i>Ajukan Peminjaman
                                    </a>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">
                                            <i class="bx bx-time me-1"></i>Proses persetujuan 1-2 hari kerja
                                        </small>
                                    </div>
                                @else
                                    <button class="btn btn-outline-secondary w-100 btn-lg" disabled>
                                        <i class="bx bx-lock me-2"></i>Sedang Digunakan
                                    </button>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">
                                            <i class="bx bx-info-circle me-1"></i>Silakan coba lagi nanti
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick View Modal -->
                <div class="modal fade" id="quickViewModal{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">{{ $item->nama_fasilitas }}</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/' . $item->gambar) }}"
                                            class="img-fluid rounded shadow" alt="{{ $item->nama_fasilitas }}">
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Deskripsi Fasilitas</h6>
                                        <p class="text-muted mb-4">{{ $item->deskripsi }}</p>

                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="card bg-warning bg-opacity-10 border-warning">
                                                    <div class="card-body text-center">
                                                        <h6 class="text-warning mb-1">
                                                            <i class="bx bx-money me-2"></i>Biaya Peminjaman
                                                        </h6>
                                                        <h4 class="text-warning fw-bold mb-0">
                                                            Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                                        </h4>
                                                        <small class="text-muted">per hari</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <h6 class="fw-bold">Status</h6>
                                                <span
                                                    class="badge bg-{{ $item->kondisi == 'true' ? 'success' : 'danger' }} fs-6">
                                                    {{ $item->kondisi == 'true' ? 'Tersedia' : 'Sedang Digunakan' }}
                                                </span>
                                            </div>

                                            <div class="col-6">
                                                <h6 class="fw-bold">Kategori</h6>
                                                <span class="badge bg-info fs-6">Masyarakat Umum</span>
                                            </div>
                                        </div>

                                        @if ($item->kondisi == 'true')
                                            <div class="alert alert-success mt-3" role="alert">
                                                <small>
                                                    <i class="bx bx-info-circle me-1"></i>
                                                    <strong>Catatan:</strong> Pembayaran dilakukan setelah pengajuan
                                                    disetujui.
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                @if ($item->kondisi == 'true')
                                    <a href="{{ route('non_mahasiswa.peminjaman.create', ['fasilitas_id' => $item->id]) }}"
                                        class="btn btn-primary">
                                        <i class="bx bx-calendar-plus me-2"></i>Ajukan Peminjaman
                                    </a>
                                @endif
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bx bx-search-alt-2 display-1 text-muted"></i>
                        </div>
                        <h4 class="text-muted">Tidak ada fasilitas ditemukan</h4>
                        <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang digunakan.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- No Results Found -->
        <div id="no-results" class="text-center py-5 d-none">
            <div class="mb-4">
                <i class="bx bx-search-alt-2 display-1 text-muted"></i>
            </div>
            <h4 class="text-muted">Tidak ada fasilitas yang sesuai</h4>
            <p class="text-muted">Coba gunakan kata kunci lain atau ubah filter pencarian.</p>
            <button class="btn btn-outline-primary" onclick="resetFilters()">
                <i class="bx bx-refresh me-2"></i>Reset Filter
            </button>
        </div>

    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-facility');
            const filterStatus = document.getElementById('filter-status');
            const filterPrice = document.getElementById('filter-price');
            const sortBy = document.getElementById('sort-by');
            const facilityCards = document.querySelectorAll('.facility-card');
            const noResults = document.getElementById('no-results');
            const facilityList = document.getElementById('facility-list');

            // Search and filter functionality
            function performSearch() {
                const keyword = searchInput.value.toLowerCase();
                const statusFilter = filterStatus.value;
                const priceFilter = filterPrice.value;
                let visibleCount = 0;

                facilityCards.forEach(card => {
                    const name = card.dataset.name;
                    const status = card.dataset.status;
                    const price = parseInt(card.dataset.biaya);

                    const matchesSearch = name.includes(keyword);
                    const matchesStatus = statusFilter === '' || status === statusFilter;

                    let matchesPrice = true;
                    if (priceFilter !== '') {
                        const [minPrice, maxPrice] = priceFilter.split('-').map(Number);
                        matchesPrice = price >= minPrice && price <= maxPrice;
                    }

                    if (matchesSearch && matchesStatus && matchesPrice) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0 && facilityCards.length > 0) {
                    noResults.classList.remove('d-none');
                    facilityList.style.display = 'none';
                } else {
                    noResults.classList.add('d-none');
                    facilityList.style.display = 'flex';
                }
            }

            // Sort functionality
            function performSort() {
                const sortValue = sortBy.value;
                const cardsArray = Array.from(facilityCards);
                const parent = facilityCards[0].parentNode;

                cardsArray.sort((a, b) => {
                    switch (sortValue) {
                        case 'nama':
                            return a.dataset.name.localeCompare(b.dataset.name);
                        case 'biaya-rendah':
                            return parseInt(a.dataset.biaya) - parseInt(b.dataset.biaya);
                        case 'biaya-tinggi':
                            return parseInt(b.dataset.biaya) - parseInt(a.dataset.biaya);
                        default:
                            return 0;
                    }
                });

                // Reorder elements
                cardsArray.forEach(card => parent.appendChild(card));
            }

            // Event listeners
            searchInput.addEventListener('keyup', performSearch);
            filterStatus.addEventListener('change', performSearch);
            filterPrice.addEventListener('change', performSearch);
            sortBy.addEventListener('change', performSort);

            // Reset filters function
            window.resetFilters = function() {
                searchInput.value = '';
                filterStatus.value = '';
                filterPrice.value = '';
                sortBy.value = 'nama';
                performSearch();
                performSort();
            }

            // Add loading animation for better UX
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const loadingState = document.getElementById('loading-state');

                loadingState.classList.remove('d-none');
                facilityList.style.display = 'none';

                searchTimeout = setTimeout(() => {
                    loadingState.classList.add('d-none');
                    facilityList.style.display = 'flex';
                    performSearch();
                }, 500);
            });

            // Initialize sorting on page load
            performSort();
        });
    </script>
@endpush
