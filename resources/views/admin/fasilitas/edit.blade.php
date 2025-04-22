@extends('admin.layouts.admin')

@section('title', 'Edit Data Fasilitas')

@section('contentAdmin')
    <div
        class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full">
                <div class="card p-0">
                    <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                        <h3 class="text-lg card-title leading-none">Edit Data Fasilitas</h3>
                    </div>
                    <form method="POST" action="{{ route('fasilitas.update', $fasilitas->id) }}" class="p-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex lg:flex-row flex-col gap-x-4">
                            <div class="w-full mb-4">
                                <label for="nama_fasilitas" class="form-label">Nama Fasilitas</label>
                                <input type="text" id="nama_fasilitas" name="nama_fasilitas" class="form-input"
                                    value="{{ old('nama_fasilitas', $fasilitas->nama_fasilitas) }}" required>
                            </div>
                        </div>

                        <div class="w-full mb-4">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-input" rows="3">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                        </div>

                        <div class="flex lg:flex-row flex-col gap-x-4">
                            <div class="w-full mb-4">
                                <label for="kondisi" class="form-label">Status</label>
                                <select id="kondisi" name="kondisi" class="form-input" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="true"
                                        {{ old('kondisi', $fasilitas->kondisi) == 'true' ? 'selected' : '' }}>Digunakan</option>
                                    <option value="false"
                                        {{ old('kondisi', $fasilitas->kondisi) == 'false' ? 'selected' : '' }}>Tidak Digunakan</option>
                                </select>
                            </div>
                            <div class="w-full mb-4">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" id="lokasi" name="lokasi" class="form-input"
                                    value="{{ old('lokasi', $fasilitas->lokasi) }}" required>
                            </div>
                        </div>

                        <div class="flex lg:flex-row flex-col gap-x-4 mb-4">
                            <div class="w-full mb-4">
                                <label for="kapasitas" class="form-label">Kapasitas</label>
                                <input type="number" id="kapasitas" name="kapasitas" class="form-input"
                                    value="{{ old('kapasitas', $fasilitas->kapasitas) }}" required>
                            </div>
                        </div>

                        {{-- Gambar --}}
                        <div class="w-full mb-6">
                            <p class="form-label">Thumbnail (400x250)</p>
                            @if ($fasilitas->gambar)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $fasilitas->gambar) }}" alt="{{ $fasilitas->nama_fasilitas }}"
                                        class="w-40 h-24 object-cover rounded">
                                </div>
                            @endif
                            <label for="thumbnail"
                                class="file-container ac-bg !bg-cover text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-input-border dark:border-dark-border border-dashed rounded-10">
                                <input type="file" id="thumbnail" name="gambar" hidden class="img-src peer/file">
                                <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                    <span
                                        class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                        <img src="{{ asset('assets/images/icons/upload-file.svg') }}" alt="icon"
                                            class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                    </span>
                                    <span class="mt-2 text-gray-500 dark:text-dark-text">Choose file</span>
                                </span>
                            </label>
                            @error('gambar')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit"
                            class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">Update</button>
                        <a href="{{ route('fasilitas') }}"
                            class="btn b-outline-static btn-disable-outline w-100 mt-2 dk-theme-card-square">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
