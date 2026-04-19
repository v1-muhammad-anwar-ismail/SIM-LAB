<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approval';
    protected $fillable = ['peminjaman_id', 'approver_id', 'status_approval', 'catatan'];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
