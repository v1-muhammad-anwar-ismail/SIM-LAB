<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Akses OTP | SIM-LAB</title>
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
            background: rgba(147, 51, 234, 0.15);
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        .card-wrapper {
            position: relative;
            z-index: 10;
            width: 90%;
            max-width: 420px;
            padding: 1px;
            background: linear-gradient(90deg, #9333ea, #3b82f6, #00d9ff, #9333ea);
            background-size: 400% 400%;
            animation: borderMove 6s ease infinite;
            clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);
            transition: all 0.3s ease;
        }

        .card-wrapper:hover {
            box-shadow: 0 0 30px rgba(147, 51, 234, 0.3);
        }

        @keyframes borderMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .auth-card {
            background-color: var(--card-bg);
            padding: 2.5rem 2rem;
            height: 100%;
            width: 100%;
            box-sizing: border-box;
            clip-path: inherit;
            text-align: center;
        }

        .icon-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(147, 51, 234, 0.1);
            border: 1px solid rgba(147, 51, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            color: #a855f7;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.2);
        }

        h1 {
            font-weight: 900;
            text-transform: uppercase;
            font-style: normal;
            letter-spacing: 0;
            font-size: 1.6rem;
            margin: 0 0 0.5rem 0;
            color: var(--text-white);
            text-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 400;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .otp-input-group {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
            direction: ltr;
        }

        .otp-box {
            width: 48px;
            height: 60px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.1);
            font-size: 1.5rem;
            font-weight: 800;
            text-align: center;
            color: var(--text-white);
            background: rgba(255,255,255,0.03);
            transition: all 0.3s;
        }

        .otp-box:focus {
            outline: none;
            border-color: #a855f7;
            box-shadow: 0 0 15px rgba(147, 51, 234, 0.4);
            background: rgba(147, 51, 234, 0.05);
            transform: translateY(-2px);
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
            border-radius: 8px;
        }

        .btn-gradient {
            background: linear-gradient(90deg, #9333ea, #3b82f6);
        }

        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(90deg, #3b82f6, #00d9ff);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-gradient:hover::before { opacity: 1; }
        .btn-gradient:hover {
            box-shadow: 0 0 25px rgba(147, 51, 234, 0.5);
            transform: translateY(-2px);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #86efac;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        .timer-text {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 1.5rem;
            font-weight: 500;
        }
        .timer-text span {
            color: var(--primary-cyan);
            font-weight: 700;
        }
        .resend-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            font-family: inherit;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: not-allowed;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 1.5rem;
            display: none;
        }
        .resend-btn.active {
            color: #a855f7;
            cursor: pointer;
            display: inline-block;
            transition: color 0.3s, text-shadow 0.3s;
        }
        .resend-btn.active:hover {
            color: #00d9ff;
            text-shadow: 0 0 10px rgba(0, 217, 255, 0.4);
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 2rem 1.5rem;
            }
            .otp-input-group {
                gap: 0.4rem;
            }
            .otp-box {
                width: 42px;
                height: 54px;
                font-size: 1.3rem;
            }
            h1 {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 360px) {
            .auth-card {
                padding: 2rem 1rem;
            }
            .otp-input-group {
                gap: 0.25rem;
            }
            .otp-box {
                width: 35px;
                height: 48px;
                font-size: 1.1rem;
            }
            h1 {
                font-size: 1.25rem;
            }
            .subtitle {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="glow-bg"></div>

@php
    $lang = session('locale', 'id');
    $tTitle = $lang === 'en' ? 'IDENTITY VERIFICATION' : 'VERIFIKASI IDENTITAS';
    $tSub = $lang === 'en' ? 'We have sent a 6-digit OTP code.<br>Enter the code to verify your account.' : 'Kami telah mengirimkan 6 digit kode OTP.<br>Masukkan kode tersebut untuk memverifikasi akun Anda.';
    $tBtn = $lang === 'en' ? 'VERIFY NOW' : 'VERIFIKASI SEKARANG';
    $tExpire = $lang === 'en' ? 'Code expires in' : 'Kode kadaluarsa dalam';
    $tResend = $lang === 'en' ? 'RESEND OTP CODE' : 'KIRIM ULANG KODE OTP';
    
    $expiresAtTimestamp = \Carbon\Carbon::parse($user->otp_expires_at)->timestamp;
    $nowTimestamp = now()->timestamp;
    $diff = max(0, $expiresAtTimestamp - $nowTimestamp);
@endphp

    <div class="card-wrapper">
        <div class="auth-card">
            <div class="icon-container">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>

            <h1>{{ $tTitle }}</h1>
            <p class="subtitle">{!! $tSub !!}</p>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
                @csrf
                <input type="hidden" name="otp" id="fullOtp">
                
                <div class="otp-input-group" id="otpGroup">
                    <input type="text" class="otp-box" maxlength="1" autocomplete="off" autofocus>
                    <input type="text" class="otp-box" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-box" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-box" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-box" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-box" maxlength="1" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-gradient">{{ $tBtn }}</button>
            </form>

            <div id="countdownContainer" class="timer-text">
                {{ $tExpire }} <span id="timerText">01:30</span>
            </div>

            <form method="POST" action="{{ route('otp.resend') }}" id="resendForm" style="margin:0;">
                @csrf
                <button type="submit" id="resendBtn" class="resend-btn">{{ $tResend }}</button>
            </form>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-box');
        const fullOtpInput = document.getElementById('fullOtp');
        const form = document.getElementById('otpForm');

        let remainingSeconds = {{ $diff }};
        const timerContainer = document.getElementById('countdownContainer');
        const timerText = document.getElementById('timerText');
        const resendBtn = document.getElementById('resendBtn');

        function updateTimer() {
            if (remainingSeconds <= 0) {
                timerContainer.style.display = 'none';
                resendBtn.style.display = 'inline-block';
                // Trigger reflow untuk animasi fade in (opsional)
                void resendBtn.offsetWidth; 
                resendBtn.classList.add('active');
                return;
            }

            const m = Math.floor(remainingSeconds / 60).toString().padStart(2, '0');
            const s = (remainingSeconds % 60).toString().padStart(2, '0');
            timerText.innerText = `${m}:${s}`;
            remainingSeconds--;
            setTimeout(updateTimer, 1000);
        }
        
        // Memulai countdown
        updateTimer();

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
            
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').trim().slice(0,6);
                if (/^\d{1,6}$/.test(pastedData)) {
                    for(let i = 0; i < pastedData.length; i++) {
                        if(inputs[i]) inputs[i].value = pastedData[i];
                    }
                    if(inputs[pastedData.length - 1]) inputs[pastedData.length - 1].focus();
                }
            });
        });

        form.addEventListener('submit', (e) => {
            let otpValue = '';
            inputs.forEach(input => {
                otpValue += input.value;
            });
            fullOtpInput.value = otpValue;

            if (otpValue.length !== 6) {
                e.preventDefault();
                alert(document.documentElement.lang === 'en' ? 'Please enter the complete 6-digit OTP code.' : 'Tolong masukkan 6 digit angka OTP dengan lengkap.');
            }
        });
    </script>
</body>
</html>
