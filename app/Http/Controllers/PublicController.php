<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratorium;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function indexHome()
    {
        // 1. Data untuk Grid Catalog di Home
        $laboratoriums = Laboratorium::withCount('alat')->get();
        $alats = Alat::with('laboratorium')->get()->filter(function($alat) {
            return $alat->kondisi !== 'rusak' && $alat->available_stok > 0;
        });

        // 2. Data Carousel (3 Lab, 4 Alat)
        $carouselLabs = Laboratorium::take(3)->get()->map(function($item) {
            $item->slide_type = 'lab';
            return $item;
        });

        $carouselAlats = Alat::with('laboratorium')
            ->where('kondisi', '!=', 'rusak')
            ->take(4)->get()->map(function($item) {
                // Ignore available stok for banner, just to show assets
                $item->slide_type = 'alat';
                return $item;
            });

        // Mencampur Lab dan Alat untuk Carousel (Bergantian)
        $ca = $carouselAlats->all();
        $cl = $carouselLabs->all();
        $carouselItems = [];
        $maxLen = max(count($ca), count($cl));
        for ($i=0; $i<$maxLen; $i++) {
            if(isset($ca[$i])) $carouselItems[] = $ca[$i];
            if(isset($cl[$i])) $carouselItems[] = $cl[$i];
        }

        return view('public.home', compact('laboratoriums', 'alats', 'carouselItems'));
    }

    public function indexAbout()
    {
        return view('public.about');
    }

    public function indexCatalog()
    {
        // Menggunakan halaman ini khusus untuk Tabel Jadwal Global
        $activeSchedules = Peminjaman::with(['user', 'laboratorium', 'detailPeminjaman.alat'])
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->where('tanggal_selesai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        return view('public.schedule', compact('activeSchedules'));
    }

    public function showDetail($type, $id)
    {
        $item = null;
        $activeSchedules = collect();

        if ($type === 'lab') {
            $item = Laboratorium::with(['master', 'aslabs'])->findOrFail($id);
            // Menampilkan waktu dan tanggal yang sudah diajukan oleh mhs lain (Status: 'disetujui' atau 'dipinjam')
            $activeSchedules = Peminjaman::with('user')
                ->where('laboratorium_id', $id)
                ->where('jenis_peminjaman', 'ruang')
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->where('tanggal_selesai', '>=', now())
                ->orderBy('tanggal_mulai', 'asc')
                ->get();
        } elseif ($type === 'alat') {
            $item = Alat::with(['laboratorium.master', 'laboratorium.aslabs'])->findOrFail($id);
            // Menampilkan jadwal untuk alat ini via korelasi detailPeminjaman
            $activeSchedules = Peminjaman::with('user')
                ->whereHas('detailPeminjaman', function ($q) use ($id) {
                    $q->where('alat_id', $id);
                })
                ->where('jenis_peminjaman', 'alat')
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->where('tanggal_selesai', '>=', now())
                ->orderBy('tanggal_mulai', 'asc')
                ->get();
        } else {
            abort(404);
        }

        return view('public.detail', compact('type', 'item', 'activeSchedules'));
    }

    public function intentBooking(Request $request)
    {
        $request->validate([
            'type' => 'required|in:lab,alat',
            'id' => 'required|integer'
        ]);

        if (Auth::check()) {
            if (Auth::user()->role === 'mahasiswa') {
                return redirect()->route('student.dashboard', [
                    'tab' => 'pengajuan', 
                    'auto_type' => $request->type, 
                    'auto_id' => $request->id
                ]);
            }
            return redirect()->back()->with('error', 'Otoritas Pengajuan hanya berlaku bagi peran Mahasiswa. Akun Anda tidak diperkenankan memesan inventaris.');
        }

        session([
            'intended_booking_type' => $request->type,
            'intended_booking_id' => $request->id
        ]);

        return redirect()->route('login')->with('warning', 'Otentikasi Menunggu! Niat pengajuan aset telah tersimpan. Masuk ke terminal Sistem untuk menebus tiket Anda.');
    }
}
