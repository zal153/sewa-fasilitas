@extends('admin.layouts.admin')
@section('title', 'Tambah Data Fasilitas')

@section('contentAdmin')
    <div
        class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full">
                <div class="card p-0">
                    <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                        <h3 class="text-lg card-title leading-none">Tambah Jadwal</h3>
                    </div>
                    <form method="POST" action="{{ route('jadwal.store') }}" class="p-6">
                        @csrf
                        <div class="w-full mb-4">
                            <label for="fasilitas_id" class="form-label">Pilih Fasilitas</label>
                            <select name="fasilitas_id" id="fasilitas_id" class="form-input" required>
                                <option value="">-- Pilih Fasilitas --</option>
                                @foreach ($fasilitas as $f)
                                    <option value="{{ $f->id }}"
                                        {{ old('fasilitas_id') == $f->id ? 'selected' : '' }}>
                                        {{ $f->nama_fasilitas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fasilitas_id')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="flex lg:flex-row flex-col gap-x-4 mb-4">
                            <div class="w-full mb-4">
                                <label class="form-label">Tanggal Mulai</label>
                                <div class="flex">
                                    <span
                                        class="form-input-group !rounded-r-none input-icon !text-gray-900 dark:text-dark-text">
                                        <i class="ri-calendar-line text-inherit"></i>
                                    </span>
                                    <input type="date" name="tanggal_mulai"
                                        class="form-input !rounded-l-none bg-[#F8F8F8] dark:bg-dark-card-two"
                                        value="{{ old('tanggal_mulai') }}" required>
                                </div>
                            </div>

                            <div class="w-full mb-4">
                                <label class="form-label">Jam Mulai</label>
                                <div class="flex">
                                    <span
                                        class="form-input-group !rounded-r-none input-icon !text-gray-900 dark:text-dark-text">
                                        <i class="ri-time-line text-inherit"></i>
                                    </span>
                                    <input type="time" name="jam_mulai"
                                        class="form-input !rounded-l-none bg-[#F8F8F8] dark:bg-dark-card-two"
                                        value="{{ old('jam_mulai') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex lg:flex-row flex-col gap-x-4 mb-4">
                            <div class="w-full mb-4">
                                <label class="form-label">Tanggal Selesai</label>
                                <div class="flex">
                                    <span
                                        class="form-input-group !rounded-r-none input-icon !text-gray-900 dark:text-dark-text">
                                        <i class="ri-calendar-line text-inherit"></i>
                                    </span>
                                    <input type="date" name="tanggal_selesai"
                                        class="form-input !rounded-l-none bg-[#F8F8F8] dark:bg-dark-card-two"
                                        value="{{ old('tanggal_selesai') }}" required>
                                </div>
                            </div>

                            <div class="w-full mb-4">
                                <label class="form-label">Jam Selesai</label>
                                <div class="flex">
                                    <span
                                        class="form-input-group !rounded-r-none input-icon !text-gray-900 dark:text-dark-text">
                                        <i class="ri-time-line text-inherit"></i>
                                    </span>
                                    <input type="time" name="jam_selesai"
                                        class="form-input !rounded-l-none bg-[#F8F8F8] dark:bg-dark-card-two"
                                        value="{{ old('jam_selesai') }}" required>
                                </div>
                            </div>
                        </div>


                        <button type="submit"
                            class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">Simpan</button>
                        <a href="{{ route('jadwal') }}"
                            class="btn b-outline-static btn-disable-outline w-100 mt-2 dk-theme-card-square">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
