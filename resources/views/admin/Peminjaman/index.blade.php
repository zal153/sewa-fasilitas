@extends('admin.layouts.admin')
@section('title', 'Data Peminjaman')
@section('contentAdmin')
    <div
        class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
        {{-- content --}}
        <div class="grid grid-cols-12">
            <div class="col-span-full">
                <div class="card p-0">
                    <div class="p-6">
                        <div class="flex-center-between">
                            <div class="flex items-center gap-5">
                                <form class="max-w-80 relative">
                                    <span class="absolute top-1/2 -translate-y-[40%] left-2.5">
                                        <i class="ri-search-line text-gray-900 dark:text-dark-text text-[14px]"></i>
                                    </span>
                                    <input type="text" placeholder="Search for..." class="form-input pl-[30px]">
                                </form>
                                <button type="button"
                                    class="font-spline_sans text-sm px-1 text-gray-900 dark:text-dark-text flex-center gap-1.5"
                                    onclick="window.location.href=window.location.href">
                                    <i class="ri-loop-right-line text-inherit text-sm"></i>
                                    <span>Refresh Data</span>
                                </button>
                            </div>
                            <a href="{{ route('peminjaman.create') }}"
                                class="btn b-light btn-primary-light dk-theme-card-square">
                                <i class="ri-add-fill text-inherit"></i>
                                <span>Tambah Data</span>
                            </a>
                        </div>
                        <div class="overflow-x-auto mt-5">
                            <table
                                class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
                                <thead>
                                    <tr>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">No.
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Kode
                                            Peminjaman
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Nama Peminjam
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Fasilitas yang
                                            Dipinjam
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Tanggal Mulai
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Tanggal
                                            Selesai</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">keperluan</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Status</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Biaya</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Pembayaran
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Disetujui Oleh
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Catatan</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one w-10">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                                    @forelse ($peminjaman as $item)
                                        <tr>
                                            <td class="p-6 py-4 dk-border-one">{{ $no++ }}</td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->kode_peminjaman }}</td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->user->name ?? '_' }}</td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->fasilitas->nama_fasilitas ?? '_' }}
                                            </td>
                                            <td class="p-6 py-4 dk-border-one">
                                                {{ $item->tanggal_mulai->format('d M Y H:i') }}</td>
                                            <td class="p-6 py-4 dk-border-one">
                                                {{ $item->tanggal_selesai->format('d M Y H:i') }}</td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->keperluan }}</td>
                                            <td class="p-6 py-4 dk-border-one">
                                                @php
                                                    $status = $item->status ?? 'Menunggu';

                                                    $badgeClass = match ($status) {
                                                        'Diproses' => 'badge-warning-light',
                                                        'Disetujui' => 'badge-success-light',
                                                        'Ditolak' => 'badge-danger-light',
                                                        'Menunggu' => 'badge-info-light',
                                                        'Batal' => 'badge-disable-light',
                                                        default => 'badge-info-light',
                                                    };
                                                @endphp

                                                <span class="badge {{ $badgeClass }} rounded-full">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->biaya }}</td>
                                            <td class="p-6 py-4 dk-border-one">
                                                <span
                                                    class="{{ $item->is_aktif ? 'badge badge-danger-light rounded-full' : 'badge badge-success-light rounded-full' }}">
                                                    {{ $item->is_aktif ? 'Belum Bayar' : 'Sudah Bayar' }}
                                                </span>
                                            </td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->approvedBy->name ?? '-' }}</td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->catatan }}</td>
                                            <td class="p-6 py-4 dk-border-one">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('peminjaman.edit', $item->id) }}"
                                                        class="btn-icon btn-primary-icon-light size-7">
                                                        <i class="ri-edit-2-line text-inherit text-[13px]"></i>
                                                    </a>
                                                    <form action="{{ route('peminjaman.destroy', $item->id) }}"
                                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn-icon btn-danger-icon-light size-7">
                                                            <i class="ri-delete-bin-line text-inherit text-[13px]"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
                        <!-- START PAGINATION -->
                        @php
                            $start = ($data->currentPage() - 1) * $data->perPage() + 1;
                            $end = min($data->currentPage() * $data->perPage(), $data->total());
                        @endphp

                        <div class="flex-center-between mt-5">
                            <div class="font-spline_sans text-sm text-gray-900 dark:text-dark-text">
                                Showing {{ $start }} to {{ $end }} of {{ $data->total() }} entries
                            </div>
                            <nav class="dk-border-one rounded-[4px] overflow-hidden">
                                <ul class="divide-x divide-gray-200 dark:divide-dark-border-three flex items-center">
                                    {{-- Previous --}}
                                    @if ($data->onFirstPage())
                                        <li><span
                                                class="font-spline_sans size-8 flex-center text-gray-400 cursor-not-allowed">‹</span>
                                        </li>
                                    @else
                                        <li><a href="{{ $data->previousPageUrl() }}"
                                                class="font-spline_sans size-8 flex-center text-gray-900 hover:text-primary-500">‹</a>
                                        </li>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                                        <li>
                                            <a href="{{ $url }}"
                                                class="font-spline_sans font-medium flex-center size-8 text-gray-900 dark:text-dark-text bg-white dark:bg-dark-icon hover:text-primary-500 {{ $data->currentPage() == $page ? 'bg-primary-500 text-white' : '' }}">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endforeach

                                    {{-- Next --}}
                                    @if ($data->hasMorePages())
                                        <li><a href="{{ $data->nextPageUrl() }}"
                                                class="font-spline_sans size-8 flex-center text-gray-900 hover:text-primary-500">›</a>
                                        </li>
                                    @else
                                        <li><span
                                                class="font-spline_sans size-8 flex-center text-gray-400 cursor-not-allowed">›</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
