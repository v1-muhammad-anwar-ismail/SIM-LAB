<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | SIM-LAB Unesa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');

        :root {
            --bg-main: #02040a;
            --card-bg: #0a0e17;
            --primary-cyan: #00d9ff;
            --text-white: #ffffff;
            --text-muted: #94a3b8;
            --error-red: #ef4444;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 7rem 0 2rem 0;
            overflow-x: hidden;
            position: relative;
        }

        .glow-bg {
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 500px;
            background: rgba(0, 217, 255, 0.08);
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        .card-wrapper {
            position: relative;
            z-index: 10;
            width: 90%;
            max-width: 550px;
            padding: 1px;
            background: linear-gradient(90deg, #22d3ee, #3b82f6, #9333ea, #22d3ee);
            background-size: 400% 400%;
            animation: borderMove 6s ease infinite;
            clip-path: polygon(25px 0, 100% 0, 100% calc(100% - 25px), calc(100% - 25px) 100%, 0 100%, 0 25px);
            transition: all 0.3s ease;
        }

        .card-wrapper:hover {
            box-shadow: 0 0 30px rgba(0, 217, 255, 0.25);
        }

        @keyframes borderMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .auth-card {
            background-color: var(--card-bg);
            padding: 2.5rem 3rem;
            height: 100%;
            width: 100%;
            box-sizing: border-box;
            clip-path: inherit;
        }

        h1 {
            font-weight: 900;
            text-transform: uppercase;
            font-style: normal;
            letter-spacing: 0;
            font-size: 1.6rem;
            margin: 0 0 0.5rem 0;
            text-align: center;
            color: var(--text-white);
            text-shadow: 0 4px 15px rgba(0,217,255,0.3);
        }

        .subtitle {
            color: var(--text-muted);
            text-align: center;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            margin-bottom: 2.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .pass-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .eye-icon {
            position: absolute;
            right: 1rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.3s ease;
            display: flex;
            padding: 0.2rem;
            border-radius: 4px;
        }

        .eye-icon:hover {
            color: var(--primary-cyan);
            background: rgba(0, 217, 255, 0.05);
        }

        .pass-wrapper input {
            padding-right: 3rem !important;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.9rem 1.1rem;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: var(--text-white);
            font-family: inherit;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-cyan);
            box-shadow: 0 0 15px rgba(0, 217, 255, 0.4);
            background: rgba(0, 217, 255, 0.05);
        }

        input::placeholder {
            color: rgba(255,255,255,0.2);
        }

        .btn {
            width: 100%;
            padding: 1.1rem;
            border: none;
            color: var(--text-white);
            font-family: inherit;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            margin-top: 1.5rem;
            border-radius: 8px;
        }

        .btn-gradient {
            background: linear-gradient(90deg, #00d9ff, #3b82f6);
        }

        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(90deg, #3b82f6, #9333ea);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-gradient:hover::before {
            opacity: 1;
        }
        
        .btn-gradient:hover {
            box-shadow: 0 0 25px rgba(0, 217, 255, 0.5);
            transform: translateY(-2px);
        }

        .bottom-link {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2rem;
        }

        .bottom-link a {
            color: var(--primary-cyan);
            text-decoration: none;
            transition: color 0.3s, text-shadow 0.3s;
            margin-left: 0.5rem;
        }

        .bottom-link a:hover {
            color: #fff;
            text-shadow: 0 0 10px var(--primary-cyan);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 2rem;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.1);
        }
        
        @media (max-width: 640px) {
            .form-row { grid-template-columns: 1fr; gap: 0; }
            .auth-card { padding: 2rem; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="glow-bg"></div>

@php
    $lang = session('locale', 'id');
    $tTitle = $lang === 'en' ? 'Student Registration' : 'Registrasi Mahasiswa';
    $tSub = $lang === 'en' ? 'Unesa Laboratory Management Information System' : 'Sistem Informasi Manajemen Laboratorium Unesa';
    $tName = $lang === 'en' ? 'Full Name' : 'Nama Lengkap';
    $tLocked = $lang === 'en' ? '(LOCKED)' : '(TERKUNCI)';
    $tFetchName = $lang === 'en' ? 'Fetching name...' : 'Mendapatkan nama...';
    $tEmail = $lang === 'en' ? 'University Email Address' : 'Alamat Email Universitas';
    $tFetchEmail = $lang === 'en' ? 'Fetching email...' : 'Mendapatkan email...';
    $tNim = $lang === 'en' ? 'Core System (NIM)' : 'Sistem Induk (NIM)';
    $tNimPlace = $lang === 'en' ? 'E.g. 24051204168' : 'Contoh: 24051204168';
    $tClass = $lang === 'en' ? 'Class' : 'Kelas';
    $tClassPlace = $lang === 'en' ? 'E.g. TI-2024A' : 'Contoh: TI-2024A';
    $tPass = $lang === 'en' ? 'Password' : 'Kata Sandi';
    $tPassPlace = $lang === 'en' ? 'Minimum 8 characters' : 'Minimal 8 karakter';
    $tConfPass = $lang === 'en' ? 'Confirm Password' : 'Konfirmasi Sandi';
    $tConfPassPlace = $lang === 'en' ? 'Repeat password' : 'Ulangi kata sandi';
    $tBtn = $lang === 'en' ? 'REGISTER ACCOUNT' : 'DAFTARKAN AKUN';
    $tAlready = $lang === 'en' ? 'Already have an account?' : 'Sudah memiliki akun?';
    $tLogin = $lang === 'en' ? 'Login here' : 'Masuk di sini';
@endphp

    <div class="card-wrapper">
        <div class="auth-card">
            <h1>{{ $tTitle }}</h1>
            <p class="subtitle">{{ $tSub }}</p>

            @if(session('success'))
                <div class="alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.4); color: #86efac; padding: 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 2rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label>{{ $tName }} <span style="color:var(--primary-cyan);font-size:0.6rem;">{{ $tLocked }}</span></label>
                    <input type="text" name="name" 
                           value="{{ old('name', $googleData['name'] ?? '') }}" 
                           required 
                           readonly 
                           style="background: rgba(255,255,255,0.01); color: var(--text-muted); cursor: not-allowed;" 
                           placeholder="{{ $tFetchName }}">
                </div>

                <div class="form-group">
                    <label>{{ $tEmail }} <span style="color:var(--primary-cyan);font-size:0.6rem;">{{ $tLocked }}</span></label>
                    <input type="email" name="email" 
                           value="{{ old('email', $googleData['email'] ?? '') }}" 
                           required 
                           readonly 
                           style="background: rgba(255,255,255,0.01); color: var(--text-muted); cursor: not-allowed;" 
                           placeholder="{{ $tFetchEmail }}">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>{{ $tNim }}</label>
                        <input type="text" name="nomor_induk" value="{{ old('nomor_induk') }}" required placeholder="{{ $tNimPlace }}">
                    </div>
                    <div class="form-group">
                        <label>{{ $tClass }}</label>
                        <input type="text" name="kelas" value="{{ old('kelas') }}" required placeholder="{{ $tClassPlace }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>{{ $tPass }}</label>
                        <div class="pass-wrapper">
                            <input type="password" name="password" id="regPass" required placeholder="{{ $tPassPlace }}">
                            <div class="eye-icon" onclick="togglePass('regPass', this)" title="Show/Hide Password">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ $tConfPass }}</label>
                        <div class="pass-wrapper">
                            <input type="password" name="password_confirmation" id="regConf" required placeholder="{{ $tConfPassPlace }}">
                            <div class="eye-icon" onclick="togglePass('regConf', this)" title="Show/Hide Password">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-gradient">{{ $tBtn }}</button>
            </form>

            <div class="bottom-link">
                {{ $tAlready }} <a href="{{ route('login') }}">{{ $tLogin }}</a>
            </div>
        </div>
    </div>
    </div>
    
    <script>
        function togglePass(inputId, iconDiv) {
            const input = document.getElementById(inputId);
            const svg = iconDiv.querySelector('svg');
            if (input.type === 'password') {
                input.type = 'text';
                // Eye-off icon
                svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                input.type = 'password';
                // Eye icon
                svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }
    </script>
</body>
</html>
