<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alat';
    protected $fillable = ['nama_alat', 'kode_alat', 'laboratorium_id', 'stok', 'kondisi', 'jenis_aset', 'deskripsi', 'fotos'];

    protected $casts = [
        'fotos' => 'array',
    ];

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'alat_id');
    }

    /**
     * Hitung sisa stok yang benar-benar masih tersedia dan belum dipinjam/diajukan
     */
    public function getAvailableStokAttribute()
    {
        // Hitung kuantitas alat yang "dikunci" oleh peminjaman aktif atau menunggu restu
        $lockedQty = DetailPeminjaman::where('alat_id', $this->id)
            ->whereHas('peminjaman', function ($query) {
                $query->whereIn('status', ['menunggu', 'disetujui', 'dipinjam']);
            })->sum('jumlah');

        $sisa = $this->stok - $lockedQty;
        return $sisa > 0 ? $sisa : 0;
    }
}
