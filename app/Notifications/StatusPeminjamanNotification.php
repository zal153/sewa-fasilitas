<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PeminjamanFasilitas;

class StatusPeminjamanNotification extends Notification
{
    use Queueable;

    protected $peminjaman;
    protected $status;

    public function __construct(PeminjamanFasilitas $peminjaman, $status)
    {
        $this->peminjaman = $peminjaman;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'status_peminjaman',
            'title' => 'Status Peminjaman Diperbarui',
            'message' => "Peminjaman {$this->peminjaman->kode_peminjaman} telah {$this->status}",
            'peminjaman_id' => $this->peminjaman->id,
            'user_name' => $this->peminjaman->user->name,
            'fasilitas_name' => $this->peminjaman->fasilitas->nama,
            'status' => $this->status,
            'created_at' => now()
        ];
    }
}
