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
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function jadwalFasilitas()
    {
        return $this->hasMany(JadwalFasilitas::class);
    }

    public function peminjamanFasilitas()
    {
        return $this->hasMany(PeminjamanFasilitas::class);
    }
}
