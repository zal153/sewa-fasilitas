<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanFasilitas extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_fasilitas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'fasilitas_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keperluan',
        'status',
        'biaya',
        'is_bayar',
        'disetujui_oleh',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'biaya' => 'decimal:2',
        'is_bayar' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
