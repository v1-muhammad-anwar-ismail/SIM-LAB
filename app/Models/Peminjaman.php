<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'user_id', 'jenis_peminjaman', 'laboratorium_id', 'tujuan_peminjaman',
        'tanggal_mulai', 'tanggal_selesai', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    public function approval()
    {
        return $this->hasMany(Approval::class);
    }
}
