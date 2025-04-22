@extends('admin.layouts.admin')

@section('title', 'Fasilitas')

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
                            <a href="{{ route('fasilitas.create') }}"
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
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Nama Fasilitas
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Gambar
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Deskripsi
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Lokasi</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Kapasitas</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Status</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one w-10">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                                    @foreach ($fasilitas as $item)
                                        <tr>
                                            <td class="p-6 py-4 dk-border-one">{{ $no++ }}</td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->nama_fasilitas }}</td>
                                            <td class="p-6 py-4 dk-border-one">
                                                {!! $item->gambar
                                                    ? '<img src="' .
                                                        asset('storage/' . $item->gambar) .
                                                        '" alt="' .
                                                        $item->nama_fasilitas .
                                                        '" class="w-24 h-16 object-cover rounded">'
                                                    : '<span class="text-gray-400">Tidak ada gambar</span>' !!}
                                            </td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->deskripsi }}</td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->lokasi }}
                                            </td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->kapasitas }}</td>
                                            <td class="p-6 py-4 dk-border-one">
                                                <span
                                                    class="{{ $item->is_aktif ? 'badge badge-danger-light rounded-full' : 'badge badge-success-light rounded-full' }}">
                                                    {{ $item->is_aktif ? 'Digunakan' : 'Tidak Digunakan' }}
                                                </span>
                                            </td>
                                            <td class="p-6 py-4 dk-border-one">
                                                <div class="flex items-center gap-2">
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('fasilitas.edit', $item->id) }}"
                                                        class="btn-icon btn-primary-icon-light size-7">
                                                        <i class="ri-edit-2-line text-inherit text-[13px]"></i>
                                                    </a>

                                                    <!-- Tombol Delete -->
                                                    <form action="{{ route('fasilitas.destroy', $item->id) }}"
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
                                    @endforeach
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
