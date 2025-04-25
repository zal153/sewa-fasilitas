@extends('admin.layouts.admin')

@section('title', 'Edit Data Peminjaman')

@section('contentAdmin')
    <div
        class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full">
                <div class="card p-0">
                    <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                        <h3 class="text-lg card-title leading-none">Edit Data Peminjaman</h3>
                    </div>
                    <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="w-full mb-4">
                            <label class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-input" value="{{ $peminjaman->user->name }}" disabled>
                        </div>

                        <div class="w-full mb-4">
                            <label class="form-label">Fasilitas</label>
                            <input type="text" class="form-input" value="{{ $peminjaman->fasilitas->nama_fasilitas }}"
                                disabled>
                        </div>

                        <div class="w-full mb-4">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-input" value="{{ $peminjaman->tanggal_pinjam }}" disabled>
                        </div>

                        <div class="w-full mb-4">
                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-input" value="{{ $peminjaman->tanggal_kembali }}" disabled>
                        </div>

                        <div class="w-full mb-4">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea id="catatan" name="catatan" class="form-input" rows="4">{{ old('catatan', $peminjaman->catatan) }}</textarea>
                        </div>

                        <button type="submit"
                            class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">Update</button>
                        <a href="{{ route('peminjaman') }}"
                            class="btn b-outline-static btn-disable-outline w-100 mt-2 dk-theme-card-square">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
