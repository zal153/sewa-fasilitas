@extends('user.layouts.template')

@section('title', 'Riwayat Pembayaran')

@section('contentUser')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">Riwayat Pembayaran</h4>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($pembayaran->isEmpty())
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bx bx-info-circle me-2"></i>
                        Belum ada riwayat pembayaran yang ditemukan. Silakan lakukan peminjaman terlebih dahulu.
                    </div>
                @else
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Kode Peminjaman</th>
                                    <th>Fasilitas</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayaran as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $p->peminjaman->kode_peminjaman ?? '-' }}</strong>
                                            <br>
                                            <small
                                                class="text-muted">{{ $p->transaction_id ?? 'No Transaction ID' }}</small>
                                        </td>
                                        <td>{{ $p->peminjaman->fasilitas->nama ?? '-' }}</td>
                                        <td>
                                            @if ($p->metode)
                                                <span class="badge bg-light text-dark">
                                                    {{ ucfirst(str_replace('_', ' ', $p->metode)) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match ($p->status) {
                                                    'berhasil' => 'bg-success text-white',
                                                    'menunggu' => 'bg-warning text-dark',
                                                    'dibatalkan' => 'bg-secondary text-white',
                                                    'kadaluarsa' => 'bg-danger text-white',
                                                    'gagal' => 'bg-danger text-white',
                                                    default => 'bg-secondary text-white',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $p->tanggal_bayar ? $p->tanggal_bayar->format('d M Y H:i') : '-' }}
                                            <br>
                                            <small class="text-muted">{{ $p->created_at->format('d M Y H:i') }}</small>
                                        </td>
                                        <td>
                                            @if ($p->status === 'menunggu')
                                                <a href="{{ route('bayar', $p->peminjaman->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bx bx-credit-card"></i> Bayar
                                                </a>
                                            @endif

                                            @if ($p->status === 'berhasil')
                                                <button class="btn btn-sm btn-outline-success" disabled>
                                                    <i class="bx bx-check"></i> Lunas
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
