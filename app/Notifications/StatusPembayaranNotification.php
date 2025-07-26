<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PembayaranFasilitas;

class StatusPembayaranNotification extends Notification
{
    use Queueable;

    protected $pembayaran;
    protected $status;

    public function __construct(PembayaranFasilitas $pembayaran, $status)
    {
        $this->pembayaran = $pembayaran;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'status_pembayaran',
            'title' => 'Status Pembayaran Diperbarui',
            'message' => "Pembayaran {$this->pembayaran->order_id} telah {$this->status}",
            'pembayaran_id' => $this->pembayaran->id,
            'order_id' => $this->pembayaran->order_id,
            'amount' => $this->pembayaran->amount,
            'status' => $this->status,
            'created_at' => now()
        ];
    }
}
