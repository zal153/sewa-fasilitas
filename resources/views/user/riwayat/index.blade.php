@extends('user.layouts.template')
@section('title', 'Riwayat Peminjaman')

@section('contentUser')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Riwayat Peminjaman</h4>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter & Search -->
        <form method="GET" id="perPageForm" class="row mb-4 g-3 align-items-center">
            <!-- Search -->
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">Search</span>
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari...">
                </div>
            </div>

            <!-- Per Page -->
            <div class="col-md-3 ms-auto">
                <div class="input-group">
                    <label class="input-group-text">Tampilkan</label>
                    <select name="per_page" class="form-select" onchange="document.getElementById('perPageForm').submit()">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="input-group-text">item</span>
                </div>
            </div>
        </form>

        <!-- Table Card -->
        <div class="card">
            <h5 class="card-header">Data Riwayat Peminjaman</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Fasilitas</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                            @if ($adaNonMahasiswa)
                                <th>Biaya</th>
                                <th>Pembayaran</th>
                            @endif
                            <th>Disetujui Oleh</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->user->name ?? '_' }}</td>
                                <td>{{ $item->fasilitas->nama_fasilitas ?? '_' }}</td>
                                <td>{{ $item->tanggal_mulai->format('d/m/Y') }}</td>
                                <td>{{ $item->tanggal_selesai->format('d/m/Y') }}</td>
                                <td>{{ $item->keperluan }}</td>
                                <td>
                                    @php
                                        $status = $item->status ?? 'diajukan';
                                        $badgeClass = match ($status) {
                                            'diproses' => 'bg-secondary',
                                            'disetujui' => 'bg-success',
                                            'ditolak' => 'bg-danger',
                                            'diajukan' => 'bg-warning text-dark',
                                            default => 'bg-info',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                </td>

                                @if ($adaNonMahasiswa)
                                    <td>Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($item->is_aktif)
                                            <span class="badge bg-danger">Belum Bayar</span>
                                        @else
                                            <span class="badge bg-success">Sudah Bayar</span>
                                        @endif
                                    </td>
                                @endif

                                <td>{{ $item->approvedBy->name ?? 'Belum Disetujui' }}</td>
                                <td>{{ $item->catatan }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if ($item->status === 'disetujui')
                                            <a href="{{ route('mahasiswa.riwayat.print', $item->id) }}"
                                                class="btn btn-sm btn-warning" target="_blank" title="Cetak Surat">
                                                <i class="bx bx-printer"></i>
                                            </a>
                                        @else
                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Surat hanya dapat dicetak setelah peminjaman disetujui">
                                                <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                    <i class="bx bx-printer"></i>
                                                </button>
                                            </span>
                                        @endif

                                        <form action="{{ route('mahasiswa.riwayat.delete', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">Belum ada data peminjaman 😴</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Menampilkan {{ $start }} sampai {{ $end }} dari {{ $peminjaman->total() }} data
            </div>
            <div>
                {{ $peminjaman->links() }}
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        </script>
    @endpush
@endsection
