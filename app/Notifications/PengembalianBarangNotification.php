<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PeminjamanFasilitas;

class PengembalianBarangNotification extends Notification
{
    use Queueable;

    protected $peminjaman;

    public function __construct(PeminjamanFasilitas $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'pengembalian_barang',
            'title' => 'Pengembalian Barang',
            'message' => "Barang {$this->peminjaman->fasilitas->nama} telah dikembalikan oleh {$this->peminjaman->user->name}",
            'peminjaman_id' => $this->peminjaman->id,
            'user_name' => $this->peminjaman->user->name,
            'fasilitas_name' => $this->peminjaman->fasilitas->nama,
            'tanggal_selesai' => $this->peminjaman->tanggal_selesai,
            'created_at' => now()
        ];
    }
}
