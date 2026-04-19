<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
    protected $table = 'laboratorium';
    protected $fillable = ['nama_lab', 'deskripsi', 'master_id', 'fotos', 'max_aslab'];

    protected $casts = [
        'fotos' => 'array',
    ];

    public function master()
    {
        return $this->belongsTo(User::class, 'master_id');
    }

    public function aslabs()
    {
        return $this->hasMany(User::class, 'laboratorium_id')->where('role', 'asisten');
    }

    public function alat()
    {
        return $this->hasMany(Alat::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
