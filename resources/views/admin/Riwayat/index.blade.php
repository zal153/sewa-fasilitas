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
                                        @if ($adaNonMahasiswa)
                                            <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Biaya</th>
                                            <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">
                                                Pembayaran
                                            </th>
                                        @endif
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Disetujui Oleh
                                        </th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Catatan</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one w-10">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                                    @forelse ($riwayat as $item)
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
                                            @if ($adaNonMahasiswa)
                                                <td class="p-6 py-4 dk-border-one">
                                                    <span
                                                        class="{{ $item->is_aktif ? 'badge badge-danger-light rounded-full' : 'badge badge-success-light rounded-full' }}">
                                                        {{ $item->is_aktif ? 'Belum Bayar' : 'Sudah Bayar' }}
                                                    </span>
                                                </td>
                                            @endif
                                            <td class="p-6 py-4 dk-border-one">{{ $item->approvedBy->name ?? '-' }}</td>
                                            <td class="p-6 py-4 dk-border-one">{{ $item->catatan }}</td>
                                            <td class="p-6 py-4 dk-border-one">
                                                <div class="flex items-center gap-2">
                                                    <!-- VIEW ICON -->
                                                    <button onclick="showDetail({{ $item->id }})"
                                                        class="btn-icon btn-info-icon-light size-7">
                                                        <i class="ri-eye-line text-inherit text-[13px]"></i>
                                                    </button>

                                                    <!-- PRINT ICON -->
                                                    <a href="{{ route('riwayat.print', $item->id) }}" target="_blank"
                                                        class="btn-icon btn-warning-icon-light size-7">
                                                        <i class="ri-printer-line text-inherit text-[13px]"></i>
                                                    </a>

                                                    <!-- DELETE ICON -->
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
                                        <div id="modal-detail" class="fixed inset-0 bg-black/50 z-60 hidden">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-auto mt-20 p-6 relative">
                                                <div id="detail-container">Loading...</div>
                                            </div>
                                        </div>
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

    <script>
        function showDetail(id) {
            console.log("Menampilkan detail untuk ID:", id);
            $.ajax({
                url: '/admin/riwayat/detail/' + id,
                method: 'GET',
                success: function(response) {
                    const modalContent = `
                <div class="relative bg-white dark:bg-dark-card rounded-lg shadow info-border-left">
                    <button type="button" class="flex-center absolute top-3 end-2.5 hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 close-button">
                        <i class="ri-close-line text-gray-500 dark:text-dark-text text-xl"></i>
                    </button>
                    <div class="p-4 md:py-7 flex-center flex-col text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <path d="M23.3333 29C23.3333 29.3978 23.1752 29.7794 22.8939 30.0607C22.6126 30.342 22.2311 30.5 21.8333 30.5C21.0376 30.5 20.2745 30.1839 19.7119 29.6213C19.1493 29.0587 18.8333 28.2956 18.8333 27.5V20C18.4354 20 18.0539 19.842 17.7726 19.5607C17.4913 19.2794 17.3333 18.8978 17.3333 18.5C17.3333 18.1022 17.4913 17.7206 17.7726 17.4393C18.0539 17.158 18.4354 17 18.8333 17C19.6289 17 20.392 17.3161 20.9546 17.8787C21.5172 18.4413 21.8333 19.2044 21.8333 20V27.5C22.2311 27.5 22.6126 27.658 22.8939 27.9393C23.1752 28.2206 23.3333 28.6022 23.3333 29ZM39.8333 20C39.8333 23.8567 38.6896 27.6269 36.5469 30.8336C34.4042 34.0404 31.3587 36.5397 27.7956 38.0156C24.2324 39.4916 20.3116 39.8777 16.529 39.1253C12.7464 38.3729 9.2718 36.5157 6.54468 33.7886C3.81755 31.0615 1.96036 27.5869 1.20795 23.8043C0.455536 20.0216 0.841701 16.1008 2.31761 12.5377C3.79352 8.97451 6.29288 5.92903 9.49964 3.78634C12.7064 1.64366 16.4765 0.5 20.3333 0.5C25.5033 0.50546 30.46 2.56167 34.1158 6.21745C37.7716 9.87322 39.8278 14.83 39.8333 20ZM36.8333 20C36.8333 16.7366 35.8656 13.5465 34.0525 10.8331C32.2395 8.11968 29.6625 6.00483 26.6475 4.75599C23.6326 3.50714 20.315 3.18039 17.1143 3.81704C13.9136 4.4537 10.9736 6.02517 8.666 8.33274C6.35843 10.6403 4.78696 13.5803 4.1503 16.781C3.51365 19.9817 3.8404 23.2993 5.08925 26.3143C6.33809 29.3293 8.45294 31.9062 11.1664 33.7192C13.8798 35.5323 17.0699 36.5 20.3333 36.5C24.7078 36.495 28.9018 34.7551 31.995 31.6618C35.0883 28.5685 36.8283 24.3745 36.8333 20ZM19.5833 14C20.0283 14 20.4633 13.868 20.8333 13.6208C21.2033 13.3736 21.4917 13.0222 21.662 12.611C21.8323 12.1999 21.8768 11.7475 21.79 11.311C21.7032 10.8746 21.4889 10.4737 21.1742 10.159C20.8596 9.84434 20.4587 9.63005 20.0222 9.54323C19.5858 9.45642 19.1334 9.50097 18.7222 9.67127C18.3111 9.84157 17.9597 10.13 17.7125 10.5C17.4652 10.87 17.3333 11.305 17.3333 11.75C17.3333 12.3467 17.5703 12.919 17.9923 13.341C18.4142 13.7629 18.9865 14 19.5833 14Z" fill="#498CFF"/>
                        </svg>
                        <h3 class="card-title text-2xl mt-3">Information</h3>
                        <p class="text-gray-500 dark:text-dark-text font-medium px-[5%] mt-1.5">
                            ${response}
                        </p>
                    </div>
                </div>
            `;
                    // Menampilkan modal di container
                    $('#modal-detail').html(modalContent);
                    $('#modal-detail').removeClass('hidden');
                },
                error: function(xhr) {
                    alert('Gagal mengambil data.');
                }
            });
        }
    </script>
@endsection
