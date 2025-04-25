@extends('user.layouts.template')
@section('title', 'Form Peminjaman')

@section('contentUser')
    <div class="px-6 pb-20 pt-6">
        <div class="flex items-center mb-4 justify-between">
            <h1 class="inline-block xl:text-xl text-lg font-semibold leading-6">
                Form Pengajuan Peminjaman
            </h1>
        </div>
        <div class="grid grid-cols gap-6">
            <div class="xl:col-span-8 col-span-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('mahasiswa.peminjaman.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="mb-2 block text-gray-800 font-semibold">Nama</label>
                                <input type="text" value="{{ auth()->user()->name }}" disabled
                                    class="text-base border border-gray-300 text-gray-900 rounded-md block w-full p-2 px-3 bg-gray-100" />
                            </div>
                            <div class="mb-3">
                                <label for="fasilitas_id" class="mb-2 block text-gray-800 font-semibold">Pilih
                                    Fasilitas</label>
                                <select name="fasilitas_id" id="fasilitas_id" required
                                    class="text-base border border-gray-300 text-gray-900 rounded-md block w-full p-2 px-3">
                                    <option value="">-- Pilih Fasilitas --</option>
                                    @foreach ($fasilitas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_fasilitas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="mb-2 block text-gray-800 font-semibold">Tanggal
                                    Mulai</label>
                                <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai" required
                                    class="text-base border border-gray-300 text-gray-900 rounded-md block w-full p-2 px-3" />
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="mb-2 block text-gray-800 font-semibold">Tanggal
                                    Selesai</label>
                                <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai" required
                                    class="text-base border border-gray-300 text-gray-900 rounded-md block w-full p-2 px-3" />
                            </div>
                            <div class="mb-3">
                                <label for="keperluan" class="mb-2 block text-gray-800 font-semibold">Keperluan</label>
                                <textarea name="keperluan" id="keperluan" rows="4" required
                                    class="text-base border border-gray-300 text-gray-900 rounded-md block w-full p-2 px-3"></textarea>
                            </div>

                            <button type="submit"
                                class="btn gap-x-2 bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-800">Ajukan</button>
                            <a href="{{ route('mahasiswa.peminjaman') }}"
                                class="btn gap-x-2 bg-red-600 text-white border-red-600 hover:bg-red-700">Kembali</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
