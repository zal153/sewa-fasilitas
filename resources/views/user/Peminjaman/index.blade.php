@extends('user.layouts.template')

@section('title', 'Pengajuan Peminjaman Fasilitas')

@section('contentUser')
    <div class="px-6 pb-20 pt-6">
        <!-- Header -->
        <div class="flex items-center mb-4 justify-between">
            <h1 class="inline-block xl:text-xl text-lg font-semibold leading-6">Pengajuan Peminjaman Fasilitas</h1>
        </div>

        <!-- Deskripsi Halaman -->
        <div class="mb-6">
            <p>Di halaman ini, kamu dapat memilih fasilitas yang ingin dipinjam dan mengisi form pengajuan untuk
                melanjutkan. Pastikan semua data sudah benar sebelum mengajukan.</p>
        </div>

        <!-- Pencarian dan Filter -->
        <div class="mt-8 mb-4">
            <label for="search-facility" class="block text-sm font-medium text-gray-700">Cari Fasilitas</label>
            <input type="search" id="search-facility" class="mt-2 p-2 border border-gray-300 rounded-md w-full"
                placeholder="Cari fasilitas berdasarkan nama...">
        </div>

        <!-- Daftar Fasilitas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($fasilitas as $item)
                <div class="card bg-white shadow-lg rounded-lg p-4">
                    <h3 class="font-semibold text-lg">{{ $item->nama_fasilitas }}</h3>
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_fasilitas }}"
                        class="w-full h-32 object-cover rounded-md mt-2">
                    <p class="text-sm text-gray-600 mt-2">{{ $item->deskripsi }}</p>
                    <p class="mt-2 text-gray-700">Biaya: Rp. {{ number_format($item->biaya, 0, ',', '.') }}</p>
                    <p class="mt-2 text-gray-700">Status:
                        {{ $item->is_aktif == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                    </p>

                    <!-- Tombol untuk mengajukan -->
                    @if ($item->is_aktif == 'tersedia')
                        <a href="{{ route('mahasiswa.peminjaman.create', ['fasilitas_id' => $item->id]) }}"
                            class="btn mt-3 bg-indigo-600 text-white hover:bg-indigo-700">Ajukan Peminjaman</a>
                    @else
                        <button class="btn mt-3 bg-gray-300 text-gray-600 cursor-not-allowed">Tidak Tersedia</button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search-facility');
        const cards = document.querySelectorAll('.card');

        searchInput.addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase();

            cards.forEach(card => {
                const facilityName = card.querySelector('h3').textContent.toLowerCase();
                if (facilityName.includes(keyword)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>

@endsection
