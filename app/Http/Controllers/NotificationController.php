<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Tandai semua notifikasi menjadi sudah dibaca saat user membuka halamannya
        Notifikasi::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Ambil riwayat notifikasi lengkap
        $notifikasis = Notifikasi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $lang = session('locale', 'id');

        return view('notifications.index', compact('user', 'notifikasis', 'lang'));
    }
}
