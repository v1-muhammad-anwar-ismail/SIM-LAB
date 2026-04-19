<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'nomor_induk', 'kelas', 'google_id', 'avatar', 'otp_code', 'otp_expires_at', 'laboratorium_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function laboratorium()
    {
        return $this->hasMany(Laboratorium::class, 'master_id');
    }

    public function laboratorium_jaga()
    {
        return $this->belongsTo(Laboratorium::class, 'laboratorium_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function approval()
    {
        return $this->hasMany(Approval::class, 'approver_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
