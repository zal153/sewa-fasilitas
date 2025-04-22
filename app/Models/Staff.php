<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'departemen',
        'jabatan',
        'can_approve',
        'kontak',
    ];

    protected $casts = [
        'can_approve' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
