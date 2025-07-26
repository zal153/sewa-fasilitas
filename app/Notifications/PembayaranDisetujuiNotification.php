<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\PeminjamanFasilitas;

class PeminjamanDisetujuiNotification extends Notification
{
    use Queueable;

    protected $peminjaman;

    public function __construct(PeminjamanFasilitas $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'peminjaman_disetujui',
            'title' => 'Peminjaman Disetujui',
            'message' => "Peminjaman fasilitas {$this->peminjaman->fasilitas->nama} dengan kode {$this->peminjaman->kode_peminjaman} telah disetujui.",
            'data' => [
                'peminjaman_id' => $this->peminjaman->id,
                'kode_peminjaman' => $this->peminjaman->kode_peminjaman,
                'fasilitas_nama' => $this->peminjaman->fasilitas->nama,
                'tanggal_mulai' => $this->peminjaman->tanggal_mulai,
                'tanggal_selesai' => $this->peminjaman->tanggal_selesai,
            ]
        ];
    }
}
