<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // SHOW FORMS
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister(Request $request)
    {
        $googleData = $request->session()->get('google_registration');

        // Jika tidak ada data dari Google, larang akses ke halaman Pendaftaran Manual
        if (!$googleData) {
            return redirect()->route('login')->withErrors(['Pendaftaran akun baru wajib menggunakan Otentikasi Google Kampus.']);
        }

        return view('auth.register', compact('googleData'));
    }

    public function showOtp()
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = \App\Models\User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }
        
        return view('auth.otp-verification', compact('user'));
    }

    // REGISTRATION LOGIC
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255', 'unique:users',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@mhs.unesa.ac.id')) {
                        $fail('Mahasiswa wajb menggunakan email dengan domain @mhs.unesa.ac.id');
                    }
                },
            ],
            'nomor_induk' => 'required|string|max:50|unique:users',
            'kelas' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $googleData = $request->session()->get('google_registration');

        $otp = sprintf("%06d", mt_rand(1, 999999));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_induk' => $request->nomor_induk,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'otp_code' => $otp,
            'otp_expires_at' => now()->addSeconds(90),
            'google_id' => $googleData['google_id'] ?? null,
            'avatar' => $googleData['avatar'] ?? null,
        ]);
        
        if ($googleData) {
             $request->session()->forget('google_registration');
        }

        // Send OTP via Email
        Mail::to($user->email)->send(new OtpMail($otp));

        // Let session know which user is waiting for OTP
        session(['otp_user_id' => $user->id]);

        return redirect()->route('otp.verify')->with('success', 'Akun berhasil dibuat. Kode OTP telah dikirim ke email Anda.');
    }

    // VERIFY OTP LOGIC
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['Terdapat kesalahan memuat sesi OTP. Silakan login kembali.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa.']);
        }

        // Successfully verified
        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        session()->forget('otp_user_id');

        // Auto login
        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    // RESEND OTP LOGIC
    public function resendOtp(Request $request)
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['Sesi telah habis.']);
        }
        
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        $otp = sprintf("%06d", mt_rand(1, 999999));
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addSeconds(90)
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return back()->with('success', 'Kode OTP baru telah berhasil dikirim ulang ke email Anda.');
    }

    // FORGOT PASSWORD LUPA SANDI
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email'], [
            'email.exists' => 'Kami tidak dapat menemukan profil dengan nama domain email tersebut.'
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addSeconds(90)
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));
        
        session(['reset_email' => $user->email]);

        return redirect()->route('reset.password')->with('success', 'Kode otoritas OTP reset sandi telah kami layangkan ke email Anda.');
    }

    public function showResetPassword()
    {
        if (!session('reset_email')) {
            return redirect()->route('forgot.password');
        }
        return view('auth.reset-password');
    }

    public function updatePasswordWithOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('forgot.password')->withErrors(['Sesi pemulihan jembatan telah putus (Expired). Ulangi kembali.']);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            session()->forget('reset_email');
            return redirect()->route('login');
        }

        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP meleset. Autentikasi ditolak.']);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Hitungan waktu kedaluwarsaan OTP telah habis.']);
        }

        // Action Reset Keamanan Penuh (Prevent Replay Attacks)
        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Kredensial Kata Sandi berhasil dipugar ulang! Silakan masuk dengan perlengkapan sandi yang baru.');
    }

    // LOGIN LOGIC
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Check if student is verified
            if ($user->role === 'mahasiswa' && !$user->email_verified_at) {
                // Generates new OTP
                $otp = sprintf("%06d", mt_rand(1, 999999));
                $user->update([
                    'otp_code' => $otp,
                    'otp_expires_at' => now()->addSeconds(90)
                ]);
                Mail::to($user->email)->send(new OtpMail($otp));
                
                Auth::logout();
                session(['otp_user_id' => $user->id]);
                return redirect()->route('otp.verify')->withErrors(['email' => 'Email belum diverifikasi. Kode OTP baru telah dikirim.']);
            }

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    // LOGOUT LOGIC
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // GOOGLE OAUTH REDIRECT
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // GOOGLE OAUTH CALLBACK
    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            if (Auth::check()) {
                $user = Auth::user();
                $route = $this->getDashboardRoute($user);
                return redirect()->route($route, ['tab' => 'settings'])->with('error', 'Terjadi kesalahan saat menghubungi API Google (Server Timeout / Konfigurasi URL).');
            }
            return redirect()->route('login')->withErrors(['Terjadi kesalahan saat menghubungi Google.']);
        }

        // 1. Jika User sedang login (SSO Tautkan Akun dari Pengaturan)
        if (Auth::check()) {
            $currentUser = Auth::user();

            // Cek apakah akun Google ini sudah dipakai user lain
            $existingGoogleUser = User::where('google_id', $googleUser->getId())
                                      ->where('id', '!=', $currentUser->id)
                                      ->first();
                                      
            if ($existingGoogleUser) {
                // Return to appropriate dashboard settings
                $route = $this->getDashboardRoute($currentUser);
                return redirect()->route($route, ['tab' => 'settings'])->with('error', 'Akun Google ini sudah tertaut dengan pengguna lain di sistem.');
            }

            // Tautkan kredensial Auth
            $currentUser->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $currentUser->avatar ? $currentUser->avatar : $googleUser->getAvatar()
            ]);

            $route = $this->getDashboardRoute($currentUser);
            return redirect()->route($route, ['tab' => 'settings'])->with('success', 'Sertifikat keamanan Google SSO berhasil ditautkan ke profil Anda!');
        }

        // 2. Jika tidak login, cek apakah ini percobaan Login atau Register
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Akun sudah ada di Database, perbarui id/avatar lalu Login otomatis
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
            if (!$user->avatar && $googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }
            Auth::login($user);
            return $this->redirectBasedOnRole($user);
        }

        // 3. User tidak tersimpan/mencoba Mendaftar baru
        // Kita bebaskan master lab atau siapapun dari luar domain JIKA sudah didaftarkan admin (tapi kan kalau sudah didaftar, emailnya pasti ketemu di block ke-2).
        // Jadi kalau sampai nge-block ke sini, berarti ini Pendaftaran Mahasiswa murni.
        if (!str_ends_with($googleUser->getEmail(), '@mhs.unesa.ac.id')) {
            return redirect()->route('login')->withErrors(['Pendaftaran akun baru wajib menggunakan email mahasiswa lab kampus (@mhs.unesa.ac.id). Jika Anda Staf/Dosen, silakan hubungi Admin.']);
        }

        // Tahan Sesi Sementara, Force Redirect to Full Manual Register Form
        session(['google_registration' => [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]]);

        return redirect()->route('register')->with('success', 'Akun Kampus valid! Otentikasi profil SSO divalidasi. Lanjutkan kelengkapan identitas Sistem Induk Anda.');
    }

    // UNLINK GOOGLE SSO
    public function unlinkGoogle(Request $request)
    {
        $user = Auth::user();
        $user->update(['google_id' => null]);
        
        $route = $this->getDashboardRoute($user);
        return redirect()->route($route, ['tab' => 'settings'])->with('success', 'Tautan sertifikat kredensial Google SSO telah berhasil diputuskan secara permanen dari akun Anda.');
    }

    protected function getDashboardRoute($user)
    {
        switch ($user->role) {
            case 'mahasiswa': return 'student.dashboard';
            case 'master': return 'master.dashboard';
            case 'asisten': return 'asisten.dashboard';
            case 'dosen': return 'dosen.dashboard';
            case 'admin': return 'admin.dashboard';
            default: return 'student.dashboard';
        }
    }

    // ROLE-BASED REDIRECTION HELPER
    protected function redirectBasedOnRole($user)
    {
        // Deep Linking Logic untuk Pengajuan Publik Katalog
        if (session('intended_booking_type') && session('intended_booking_id')) {
            $type = session('intended_booking_type');
            $id = session('intended_booking_id');
            session()->forget(['intended_booking_type', 'intended_booking_id']);
            
            if ($user->role === 'mahasiswa') {
                $autoLab = null;
                $autoAlat = null;
                if ($type === 'lab') {
                    $autoLab = $id;
                } elseif ($type === 'alat') {
                    $alatObj = \App\Models\Alat::find($id);
                    if($alatObj) {
                        $autoLab = $alatObj->laboratorium_id;
                        $autoAlat = $id;
                    }
                }

                return redirect()->route('student.dashboard', [
                    'tab' => 'pengajuan',
                    'auto_jenis' => $type === 'lab' ? 'ruang' : 'alat',
                    'auto_lab' => $autoLab,
                    'auto_alat' => $autoAlat
                ]);
            }
        }

        // Standard Redirect ke Home Page
        return redirect()->intended('/');
    }
}
