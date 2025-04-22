<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalFasilitas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_fasilitas';
    
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'fasilitas_id',
        'waktu_mulai',
        'waktu_selesai',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
}
