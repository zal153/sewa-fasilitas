@extends('user.layouts.template')
@section('title', 'Riwayat Peminjaman')

@section('contentUser')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <div class="col-md-12">
                <h4 class="fw-bold">Riwayat Peminjaman</h4>
            </div>
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

        {{-- Filter Form --}}
        <form method="GET" id="perPageForm" class="row gy-2 gx-3 align-items-center mb-4">
            <div class="col-auto">
                <label class="form-label" for="search">Cari:</label>
                <input type="search" name="search" id="search"
                    class="form-control @error('search') is-invalid @enderror" value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama...">
                @error('search')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-auto">
                <label class="form-label" for="per_page">Tampilkan:</label>
                <select name="per_page" id="per_page" onchange="document.getElementById('perPageForm').submit()"
                    class="form-select @error('per_page') is-invalid @enderror">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                @error('per_page')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </form>

        {{-- Riwayat Tabel --}}
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
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
                                        $status = $item->status ?? 'Diajukan';
                                        $badgeClass = match ($status) {
                                            'Diproses' => 'bg-secondary',
                                            'Disetujui' => 'bg-success',
                                            'Ditolak' => 'bg-danger',
                                            'Diajukan' => 'bg-warning text-dark',
                                            default => 'bg-info',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                </td>
                                @if ($adaNonMahasiswa)
                                    <td>Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $pembayaranClass = $item->is_aktif ? 'bg-label-danger' : 'bg-label-success';
                                        @endphp
                                        <span class="badge {{ $pembayaranClass }}">
                                            {{ $item->is_aktif ? 'Belum Bayar' : 'Sudah Bayar' }}
                                        </span>
                                    </td>
                                @endif
                                <td>{{ $item->approvedBy->name ?? 'Belum Disetujui' }}</td>
                                <td>{{ $item->catatan }}</td>
                                <td class="d-flex gap-2">
                                    @if ($item->status === 'Disetujui')
                                        <a href="{{ route('non_mahasiswa.riwayat.print', $item->id) }}" target="_blank"
                                            class="btn btn-warning btn-sm" title="Cetak Surat">
                                            <i class="bx bx-printer"></i>
                                        </a>
                                    @else
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Surat hanya dapat dicetak setelah peminjaman disetujui">
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                <i class="bx bx-printer"></i>
                                            </button>
                                        </span>
                                    @endif

                                    <form action="{{ route('non_mahasiswa.riwayat.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">Belum ada data peminjaman 😴</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Menampilkan {{ $start }} sampai {{ $end }} dari total {{ $peminjaman->total() }} data
            </div>
            <div>
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
@endpush
