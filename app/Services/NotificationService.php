<?php

namespace App\Services;

use App\Models\User;
use App\Models\PeminjamanFasilitas;
use App\Models\PembayaranFasilitas;
use App\Notifications\PeminjamanDisetujuiNotification;
use App\Notifications\PembayaranDisetujuiNotification;

class NotificationService
{
    public static function sendPeminjamanDisetujui(PeminjamanFasilitas $peminjaman)
    {
        $user = User::find($peminjaman->user_id);
        $user->notify(new PeminjamanDisetujuiNotification($peminjaman));
    }

    public static function sendPembayaranDisetujui(PembayaranFasilitas $pembayaran)
    {
        $user = User::find($pembayaran->peminjaman->user_id);
        $user->notify(new PembayaranDisetujuiNotification($pembayaran));
    }
}
