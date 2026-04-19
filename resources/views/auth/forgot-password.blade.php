<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi | SIM-LAB Unesa</title>
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
            background: rgba(239, 68, 68, 0.1);
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
            background: linear-gradient(90deg, #ef4444, #f59e0b, #ef4444);
            background-size: 400% 400%;
            animation: borderMove 6s ease infinite;
            clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);
            transition: all 0.3s ease;
        }

        .card-wrapper:hover {
            box-shadow: 0 0 30px rgba(239, 68, 68, 0.25);
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
            font-size: 1.5rem;
            margin: 0 0 0.2rem 0;
            text-align: center;
            color: #ef4444;
            text-shadow: 0 0 15px rgba(239,68,68,0.3);
            line-height: 1.3;
        }

        .subtitle {
            color: var(--text-muted);
            text-align: center;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            margin-bottom: 2rem;
            line-height: 1.4;
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

        input[type="email"] {
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
            border-color: #ef4444;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
            background: rgba(239, 68, 68, 0.05);
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
            background: linear-gradient(90deg, #ef4444, #f59e0b);
        }

        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(90deg, #f59e0b, #ef4444);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-gradient:hover::before { opacity: 1; }
        .btn-gradient:hover {
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.5);
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
@endphp

    <div class="card-wrapper">
        <div class="auth-card">
            <h1>{{ $lang === 'en' ? 'RECOVERY CENTER' : 'KLINIK PEMULIHAN' }}</h1>
            <p class="subtitle">{{ $lang === 'en' ? 'Reset Account Authority Access' : 'Pemugaran Otoritas Akses Akun Sistem' }}</p>

            @if($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('forgot.password') }}">
                @csrf
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label>{{ $lang === 'en' ? 'Recovery Email Address' : 'Alamat Email Terdaftar' }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                </div>

                <button type="submit" class="btn btn-gradient">{{ $lang === 'en' ? 'SEND OTP RADAR' : 'KIRIMKAN RADAR OTP' }}</button>
            </form>

            <div class="bottom-link">
                {{ $lang === 'en' ? 'Remembered your key?' : 'Teringat kembali kunci Anda?' }} <br>
                <a href="{{ route('login') }}">{{ $lang === 'en' ? 'RETURN TO LOGIN' : 'KE BERANDA LOGIN' }}</a>
            </div>
        </div>
    </div>
</body>
</html>
