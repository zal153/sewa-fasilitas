@extends('user.layouts.template')

@section('title', 'Daftar Barang Tersedia')
@section('contentUser')
    <div class="px-6 pb-20 pt-6">
        <div class="flex items-center mb-4 justify-between">
            <!-- title -->
            <h1 class="inline-block xl:text-xl text-lg font-semibold leading-6">Products</h1>
        </div>
        <div class="grid grid-cols-1">
            <div class="card" id="listjs"
                data-list="id,product_name,category_name,added_data,price_dollor,quantity_numbers,status_info,action_info">
                <div
                    class="btn-toolbar border-b border-gray-300 px-5 py-3 flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4 gap-3">
                    <div class="flex">
                        <label
                            class="leading-[1.7] p-2 px-3 border flex items-center justify-center bg-gray-200 border-gray-300 rounded-l-md">Search</label>
                        <input type="search"
                            class="border border-l-0 border-gray-300 text-gray-900 rounded-r-md focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3 disabled:opacity-50 disabled:pointer-events-none listjs-search" />
                    </div>

                    <div class="lg:ml-auto flex">
                        <label
                            class="leading-[1.7] p-2 px-3 border border-r-0 flex items-center justify-center bg-gray-200 border-gray-300 rounded-l-md">Show</label>
                        <select
                            class="text-base py-2 px-4 block w-40 border-gray-300 focus:border-indigo-600 focus:ring-indigo-600 disabled:opacity-50 disabled:pointer-events-none"
                            id="listjs-items-per-page">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label
                            class="-ml-px leading-[1.7] p-2 px-3 border border-l-0 flex items-center justify-center bg-gray-200 border-gray-300 rounded-r-md">items</label>
                    </div>
                </div>
                <div class="relative overflow-x-auto">
                <a href="{{ route('mahasiswa.peminjaman.create') }}"
                        class="p-2 px-3 mb-3 mx-3 btn gap-x-2 bg-indigo-600 text-white border-indigo-600 disabled:opacity-50 disabled:pointer-events-none hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300">Form
                        Pengajuan</a>
                    <table class="text-left w-full whitespace-nowrap">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr class="border-b border-gray-300">
                                <th class="px-6 py-3" data-sort="product_name">No.</th>
                                <th class="px-6 py-3" data-sort="category_name">Nama</th>
                                <th class="px-6 py-3" data-sort="added_data">Fasilitas</th>
                                <th class="px-6 py-3" data-sort="price_dollor">Tanggal Mulai</th>
                                <th class="px-6 py-3" data-sort="quantity_numbers">Tanggal Selesai</th>
                                <th class="px-6 py-3" data-sort="quantity_numbers">Keperluan</th>
                                <th class="px-6 py-3" data-sort="quantity_numbers">Biaya</th>
                                <th class="px-6 py-3" data-sort="status_info">Pembayaran</th>
                                <th class="px-6 py-3" data-sort="status_info">Distujui Oleh</th>
                                <th class="px-6 py-3" data-sort="action_info">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse ($peminjaman as $item)
                                <tr class="border-b border-gray-300">
                                    <td class="px-6 py-3">{{ $no++ }}</td>
                                    <td class="px-6 py-3">{{ $item->user->name ?? '_' }}</td>
                                    <td class="px-6 py-3">{{ $item->fasilitas->nama_fasilitas ?? '_' }}</td>
                                    <td class="px-6 py-3">{{ $item->tanggal_mulai->format('d/m/Y') }}</td>
                                    <td class="px-6 py-3">{{ $item->tanggal_selesai->format('d/m/Y') }}</td>
                                    <td class="px-6 py-3">{{ $item->keperluan }}</td>
                                    <td class="px-6 py-3">
                                        @php
                                            $status = $item->status ?? 'Menunggu';

                                            $badgeClass = match ($status) {
                                                'Diproses' => 'bg-yellow-100 text-yellow-900',
                                                'Disetujui' => 'bg-teal-100 text-teal-900',
                                                'Ditolak' => 'bg-red-100 text-red-900',
                                                'Menunggu' => 'bg-blue-200 text-blue-700',
                                                'Batal' => 'bg-gray-300 text-gray-900',
                                                default => 'bg-gray-100 text-gray-900',
                                            };
                                        @endphp

                                        <span
                                            class="px-2 py-1 text-sm font-medium rounded-md inline-block whitespace-nowrap text-center {{ $badgeClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">{{ $item->biaya }}</td>
                                    <td class="px-6 py-3">
                                        @php
                                            $isAktifClass = $item->is_aktif
                                                ? 'bg-red-100 text-red-900'
                                                : 'bg-teal-100 text-teal-900';
                                            $isAktifLabel = $item->is_aktif ? 'Belum Bayar' : 'Sudah Bayar';
                                        @endphp

                                        <span
                                            class="px-2 py-1 text-sm font-medium rounded-md inline-block whitespace-nowrap text-center {{ $isAktifClass }}">
                                            {{ $isAktifLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">{{ $item->approvedBy ?? '_' }}</td>
                                    <td class="px-6 py-3">{{ $item->catatan }}</td>
                                    <td class="action_info px-6 py-3 flex items-center gap-1 mt-2">
                                        <a href="#!"
                                            class="btn rounded-full h-8 w-8 flex items-center gap-x-2 bg-transparent text-gray-600 border-transparent border disabled:opacity-50 disabled:pointer-events-none hover:text-gray-800 hover:bg-gray-300 hover:border-gray-300 active:bg-gray-300 active:border-gray-300 active:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 btn-sm texttooltip"
                                            data-template="eyeOne">
                                            <i data-feather="eye"></i>
                                            <div id="eyeOne" class="hidden">
                                                <span>View</span>
                                            </div>
                                        </a>
                                        <a href="{{ route('mahasiswa.peminjaman.edit', $item->id) }}"
                                            class="btn rounded-full h-8 w-8 flex items-center gap-x-2 bg-transparent text-gray-600 border-transparent border disabled:opacity-50 disabled:pointer-events-none hover:text-gray-800 hover:bg-gray-300 hover:border-gray-300 active:bg-gray-300 active:border-gray-300 active:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 btn-sm texttooltip"
                                            data-template="editOne">
                                            <i data-feather="edit"></i>
                                            <div id="editOne" class="hidden">
                                                <span>Edit</span>
                                            </div>
                                        </a>
                                        <a href="{{ route('mahasiswa.peminjaman.destroy', $item->id) }}"
                                            class="btn rounded-full h-8 w-8 flex items-center gap-x-2 bg-transparent text-gray-600 border-transparent border disabled:opacity-50 disabled:pointer-events-none hover:text-gray-800 hover:bg-gray-300 hover:border-gray-300 active:bg-gray-300 active:border-gray-300 active:text-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 btn-sm texttooltip"
                                            data-template="trashOne">
                                            <i data-feather="trash-2"></i>
                                            <div id="trashOne" class="hidden">
                                                <span>Delete</span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="p-6 py-4 text-center text-gray-400">Belum ada data
                                        peminjaman 😴</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="btn-toolbar flex flex-col md:flex-row justify-between items-center px-6 py-4 gap-2">
                    <p class="" id="listjs-showing-items-label">Showing 100 items</p>
                    <div class="pagination-buttons flex gap-2">
                        <button
                            class="btn bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 prev">
                            Previous
                        </button>

                        <ul class="pagination flex gap-2"></ul>
                        <button
                            class="btn bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 next">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
