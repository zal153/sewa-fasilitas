  <h2 class="text-lg font-bold mb-4">Detail Riwayat Peminjaman</h2>
    <div class="space-y-2 text-sm">
        <p><strong>Kode Peminjaman:</strong> {{ $riwayat->kode_peminjaman }}</p>
        <p><strong>Nama Peminjam:</strong> {{ $riwayat->user->name ?? '-' }}</p>
        <p><strong>Fasilitas:</strong> {{ $riwayat->fasilitas->nama_fasilitas ?? '-' }}</p>
        <p><strong>Tanggal:</strong>
            {{ $riwayat->tanggal_mulai->format('d M Y H:i') }} -
            {{ $riwayat->tanggal_selesai->format('d M Y H:i') }}
        </p>
        <p><strong>Keperluan:</strong> {{ $riwayat->keperluan }}</p>
        <p><strong>Status:</strong> {{ $riwayat->status }}</p>
        <p><strong>Disetujui Oleh:</strong> {{ $riwayat->approvedBy->name ?? '-' }}</p>
        <p><strong>Catatan:</strong> {{ $riwayat->catatan ?? '-' }}</p>
    </div>
    <div class="flex justify-end gap-2 mt-6">
        <a href="{{ route('riwayat.print', $riwayat->id) }}" target="_blank" class="btn b-light btn-primary-light">
            <i class="ri-printer-line text-inherit"></i> Print
        </a>
        <button onclick="$('#modal-detail').addClass('hidden')" class="btn b-light btn-danger-light">
            <i class="ri-close-line text-inherit"></i> Tutup
        </button>
    </div>