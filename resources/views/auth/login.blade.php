<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIM-LAB Unesa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');

        :root {
            --bg-main: #02040a;
            --card-bg: #0a0e17;
            --primary-cyan: #00d9ff;
            --text-white: #ffffff;
            --text-muted: #94a3b8;
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
            box-sizing: border-box;
        }

        .glow-bg {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 400px;
            background: rgba(0, 217, 255, 0.1);
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        .card-wrapper {
            position: relative;
            z-index: 10;
            width: 90%;
            max-width: 400px;
            padding: 1px;
            background: linear-gradient(90deg, #22d3ee, #3b82f6, #9333ea, #22d3ee);
            background-size: 400% 400%;
            animation: borderMove 6s ease infinite;
            clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);
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
            padding: 2.5rem 2.5rem;
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
            font-size: 1.8rem;
            margin: 0 0 0.2rem 0;
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
            margin-bottom: 2rem;
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

        input[type="email"],
        input[type="password"],
        input[type="text"] {
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

        /* Fix for Chrome/Edge Autofill ugly white background */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px var(--card-bg) inset !important;
            -webkit-text-fill-color: var(--text-white) !important;
            transition: background-color 5000s ease-in-out 0s;
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
            margin-top: 1rem;
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

        .btn-gradient:hover::before { opacity: 1; }
        .btn-gradient:hover {
            box-shadow: 0 0 25px rgba(0, 217, 255, 0.5);
            transform: translateY(-2px);
        }

        .btn-google {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            color: var(--text-muted);
        }

        .btn-google:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            text-shadow: none;
        }

        .oauth-divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        .oauth-divider::before, .oauth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .oauth-divider::before { margin-right: 1.5em; }
        .oauth-divider::after { margin-left: 1.5em; }

        .bottom-link {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2rem;
            line-height: 1.6;
        }

        .bottom-link a {
            color: var(--primary-cyan);
            text-decoration: none;
            transition: color 0.3s, text-shadow 0.3s;
            display: inline-block;
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
        }
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="glow-bg"></div>

@php
    $lang = session('locale', 'id');
    $tSub = $lang === 'en' ? 'Laboratory Management Information System' : 'Sistem Informasi Manajemen Laboratorium';
    $tErrorGoogle = ['Error', 'Error']; // Let the error loop handle itself
    $tGoogle = $lang === 'en' ? 'Sign in with Google' : 'Masuk dengan Google';
    $tOr = $lang === 'en' ? 'OR LOGIN USING EMAIL' : 'ATAU LOGIN MENGGUNAKAN EMAIL';
    $tEmail = $lang === 'en' ? 'Email Address' : 'Alamat Email';
    $tPass = $lang === 'en' ? 'Password' : 'Kata Sandi';
    $tEmailPlace = $lang === 'en' ? 'Enter registered email' : 'Masukkan email terdaftar';
    $tPassPlace = $lang === 'en' ? 'Enter password' : 'Masukkan kata sandi';
    $tBtn = $lang === 'en' ? 'LOGIN' : 'MASUK';
    $tNew = $lang === 'en' ? 'New Student Registration?' : 'Pendaftaran Mahasiswa Baru?';
    $tUse = $lang === 'en' ? 'Use Campus Google Account' : 'Gunakan Akun Google Kampus';
@endphp

    <div class="card-wrapper">
        <div class="auth-card">
            <h1>SIM-LAB</h1>
            <p class="subtitle">{{ $tSub }}</p>

            @if($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <a href="{{ route('google.login') }}" style="text-decoration:none;">
                <button type="button" class="btn btn-google">
                    <svg viewBox="0 0 24 24" width="20" height="20">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.11c-.22-.66-.35-1.36-.35-2.11s.13-1.45.35-2.11V7.05H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.95l3.66-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.05l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;">{{ $tGoogle }}</span>
                </button>
            </a>

            <div class="oauth-divider"><span>{{ $tOr }}</span></div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label>{{ $tEmail }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ $tEmailPlace }}">
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.5rem;">
                        <label style="margin-bottom: 0;">{{ $tPass }}</label>
                        <a href="{{ route('forgot.password') }}" style="font-size: 0.75rem; color: var(--primary-cyan); text-decoration: none; font-weight: bold; transition: 0.3s;" onmouseover="this.style.textShadow='0 0 10px var(--primary-cyan)'; this.style.color='#fff';" onmouseout="this.style.textShadow='none'; this.style.color='var(--primary-cyan)';">{{ $lang === 'en' ? 'Forgot Password?' : 'Lupa Kata Sandi?' }}</a>
                    </div>
                    <div class="pass-wrapper">
                        <input type="password" name="password" id="loginPass" required placeholder="{{ $tPassPlace }}">
                        <div class="eye-icon" onclick="togglePass('loginPass', this)" title="Show/Hide Password">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-gradient">{{ $tBtn }}</button>
            </form>

            <div class="bottom-link">
                {{ $tNew }}<br><a href="{{ route('google.login') }}">{{ $tUse }}</a>
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
                iconDiv.style.color = '#ef4444'; // Red active text like danger tab
            } else {
                input.type = 'password';
                // Eye icon
                svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
                iconDiv.style.color = 'var(--text-muted)';
            }
        }
    </script>
</body>
</html>
