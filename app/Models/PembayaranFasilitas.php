<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PembayaranFasilitas extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_fasilitas';

    protected $fillable = [
        'peminjaman_id',
        'order_id',
        'transaction_id',
        'jumlah',
        'status',
        'metode',
        'bukti_pembayaran',
        'catatan_admin',
        'qr_code',
        'tanggal_bayar',
        'tanggal_approved',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'tanggal_approved' => 'datetime',
        'jumlah' => 'decimal:2'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanFasilitas::class, 'peminjaman_id');
    }
}
