@extends('user.layouts.template')
@section('title', 'Riwayat Peminjaman')

@section('contentUser')
    <div class="px-6 pt-6 pb-20">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-semibold">Riwayat Peminjaman</h1>
        </div>

        {{-- Search & Per Page Filter --}}
        <form method="GET" id="perPageForm"
            class="btn-toolbar border-b border-gray-300 px-5 py-3 flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4 gap-3">
            <!-- Search Bar -->
            <div class="flex">
                <label
                    class="leading-[1.7] p-2 px-3 border flex items-center justify-center bg-gray-200 border-gray-300 rounded-l-md">Search</label>
                <input type="search" name="search"
                    class="border border-l-0 border-gray-300 text-gray-900 rounded-r-md focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3 disabled:opacity-50 disabled:pointer-events-none"
                    value="{{ request('search') }}" placeholder="Search..." />
            </div>
            <!-- Show Items per Page -->
            <div class="lg:ml-auto flex items-center">
                <label
                    class="leading-[1.7] p-2 px-3 border border-r-0 flex items-center justify-center bg-gray-200 border-gray-300 rounded-l-md">Show</label>
                <select name="per_page" onchange="document.getElementById('perPageForm').submit()"
                    class="text-base py-2 px-4 block w-40 border-gray-300 focus:border-indigo-600 focus:ring-indigo-600 disabled:opacity-50 disabled:pointer-events-none">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <label
                    class="leading-[1.7] p-2 px-3 border border-l-0 flex items-center justify-center bg-gray-200 border-gray-300 rounded-r-md">items</label>
            </div>
        </form>


        {{-- Tabel Riwayat --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-md">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3">No.</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Fasilitas</th>
                        <th class="px-6 py-3">Tgl Mulai</th>
                        <th class="px-6 py-3">Tgl Selesai</th>
                        <th class="px-6 py-3">Keperluan</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Biaya</th>
                        <th class="px-6 py-3">Pembayaran</th>
                        <th class="px-6 py-3">Disetujui Oleh</th>
                        <th class="px-6 py-3">Catatan</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @forelse ($peminjaman as $item)
                        <tr class="border-t">
                            <td class="px-6 py-3">{{ $no++ }}</td>
                            <td class="px-6 py-3">{{ $item->user->name ?? '_' }}</td>
                            <td class="px-6 py-3">{{ $item->fasilitas->nama_fasilitas ?? '_' }}</td>
                            <td class="px-6 py-3">{{ $item->tanggal_mulai->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">{{ $item->tanggal_selesai->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">{{ $item->keperluan }}</td>
                            <td class="px-6 py-3">{{ $item->biaya }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $pembayaranClass = $item->is_aktif
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-green-100 text-green-800';
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $pembayaranClass }}">
                                    {{ $item->is_aktif ? 'Belum Bayar' : 'Sudah Bayar' }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $status = $item->status ?? 'Menunggu';
                                    $badgeClass = match ($status) {
                                        'Diproses' => 'bg-yellow-100 text-yellow-800',
                                        'Disetujui' => 'bg-green-100 text-green-800',
                                        'Ditolak' => 'bg-red-100 text-red-800',
                                        'Menunggu' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">{{ $item->approvedBy->name ?? 'Belum Disetujui' }}</td>
                            <td class="px-6 py-3">{{ $item->catatan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center px-6 py-4 text-gray-400">Belum ada data peminjaman 😴</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-600">
                Menampilkan {{ $start }} sampai {{ $end }} dari total {{ $peminjaman->total() }} data
            </div>
            <div class="flex gap-2">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
@endsection
