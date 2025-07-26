<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nama_fasilitas',
        'deskripsi',
        'lokasi',
        'kapasitas',
        'gambar',
        'status_penggunaan',
        'biaya',
    ];

    // protected $casts = [
    //     'is_aktif' => 'boolean',
    // ];

    public function sedangDisewakan()
    {
        return $this->peminjamanFasilitas()
            ->where('status', 'disetujui')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->exists();
    }

    public function tersedia()
    {
        return !$this->sedangDisewakan();
    }

    public function jadwalFasilitas()
    {
        return $this->hasMany(JadwalFasilitas::class);
    }

    public function peminjamanFasilitas()
    {
        return $this->hasMany(PeminjamanFasilitas::class);
    }
}
