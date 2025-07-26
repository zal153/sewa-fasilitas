<div style="text-align: center; margin-bottom: 20px;">
    <h1>Riwayat Peminjaman Fasilitas</h1>
    <h3>Detail Peminjaman #{{ $peminjaman->kode_peminjaman }}</h3>
</div>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Nama</th>
        <td style="border: 1px solid #000; padding: 8px;">{{ $peminjaman->user->name }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Fasilitas</th>
        <td style="border: 1px solid #000; padding: 8px;">{{ $peminjaman->fasilitas->nama_fasilitas }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Tgl Mulai</th>
        <td style="border: 1px solid #000; padding: 8px;">{{ $peminjaman->tanggal_mulai->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Tgl Selesai</th>
        <td style="border: 1px solid #000; padding: 8px;">{{ $peminjaman->tanggal_selesai->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Keperluan</th>
        <td style="border: 1px solid #000; padding: 8px;">{{ $peminjaman->keperluan }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Status</th>
        <td style="border: 1px solid #000; padding: 8px;">
            @php
                $status = $peminjaman->status ?? 'Diajukan';
            @endphp
            {{ ucfirst($status) }}
        </td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Disetujui Oleh</th>
        <td style="border: 1px solid #000; padding: 8px;">{{ $peminjaman->approvedBy->name ?? 'Belum Disetujui' }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; padding: 8px; text-align: left;">Catatan</th>
        <td style="border: 1px solid #000; padding: 8px;">{{ $peminjaman->catatan }}</td>
    </tr>
</table>

<div style="text-align: center; font-size: 12px;">
    <p class="">Dicetak pada {{ now()->format('d M Y H:i') }}</p>
    <p>Terima kasih telah menggunakan layanan kami.</p>
    <p>Jika ada pertanyaan, silakan hubungi kami.</p>
    <p>Nama Pengguna: {{ auth()->user()->name }}</p>
    <p>Nama Admin: {{ $peminjaman->approvedBy->name ?? 'Belum Disetujui' }}</p>
</div>
