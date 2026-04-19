<div class="welcome-banner" style="margin-bottom: 2rem;">
    <div class="status-badge">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        {{ $lang === 'id' ? 'Pengaturan Profil Akun' : 'Account Profile Settings' }}
    </div>
    <h1 class="welcome-title">{{ $lang === 'id' ? 'Konfigurasi Identitas' : 'Identity Configuration' }}</h1>
    <p class="welcome-subtitle">
        {{ $lang === 'id' ? 'Kelola rekam jejak identitas, keamanan sandi, dan integrasi otorisasi lintas platform Anda di sini.' : 'Manage your identity trail, password security, and cross-platform authorization integrations here.' }}
    </p>
</div>

<div class="dashboard-grid">
    <!-- Kolom Kiri: Form Profil Utama -->
    <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin: 0; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-cyan)" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            {{ $lang === 'id' ? 'Informasi Dasar' : 'Basic Information' }}
        </h3>
        
        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; justify-content: center;">
                <label for="avatarUpload" style="position: relative; width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 2px solid var(--accent-cyan); box-shadow: 0 0 15px rgba(0,217,255,0.2); cursor: pointer; display: block; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 25px rgba(0,217,255,0.6)'; this.style.transform='scale(1.05)'" onmouseout="this.style.boxShadow='0 0 15px rgba(0,217,255,0.2)'; this.style.transform='scale(1)'" title="{{ $lang === 'id' ? 'Klik untuk mengganti foto (Max 20MB)' : 'Click to change photo (Max 20MB)' }}">
                    <img id="avatarPreview" src="{{ $user->avatar ? (str_starts_with($user->avatar, 'http') ? $user->avatar : asset('storage/' . $user->avatar)) : asset('assets/images/default-avatar.png') }}" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjY2JkNWUxIiBzdHJva2Utd2lkdGg9IjIiPjxwYXRoIGQ9Ik0yMCAyMXYtMmE0IDQgMCAwIDAtNC00SDhhNCA0IDAgMCAwLTQgNHYyIj48L3BhdGg+PGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ij48L2NpcmNsZT48L3N2Zz4='" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover; background: rgba(0,0,0,0.5); padding: {{ $user->avatar ? '0' : '1.5rem' }}; box-sizing: border-box;">
                    <!-- Overlay edit SVG -->
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); display: flex; justify-content: center; padding: 4px 0;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00d9ff" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                </label>
                <div style="color: var(--text-muted); font-size: 0.7rem;">{{ $lang === 'id' ? 'Klik gambar untuk mengubah (Max: 20MB)' : 'Click image to change (Max: 20MB)' }}</div>
                <input type="file" id="avatarUpload" name="avatar" accept="image/*" class="hidden" style="display: none;" onchange="if(this.files[0].size > 20*1024*1024) { window.showHunterToast('{{ $lang === 'id' ? 'Gagal: Ukuran file melebihi 20MB!' : 'Failed: File size exceeds 20MB!' }}', 'error'); this.value = ''; return; } document.getElementById('avatarPreview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('avatarPreview').style.padding = '0';">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">{{ $lang === 'id' ? 'Nama Lengkap' : 'Full Name' }}</label>
                <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--panel-border); color: #fff; padding: 0.75rem 1rem; border-radius: 8px; font-family: inherit; transition: 0.3s; box-sizing: border-box;" onfocus="this.style.borderColor='var(--accent-cyan)'" onblur="this.style.borderColor='var(--panel-border)'">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">{{ $lang === 'id' ? 'Alamat Surel (Email)' : 'Email Address' }}</label>
                <input type="email" value="{{ $user->email }}" disabled style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid var(--panel-border); color: var(--text-muted); padding: 0.75rem 1rem; border-radius: 8px; font-family: inherit; box-sizing: border-box; cursor: not-allowed;" title="{{ $lang === 'id' ? 'Email tidak dapat diubah' : 'Email cannot be changed' }}">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">{{ $lang === 'id' ? 'Bio / Kutipan Singkat' : 'Bio / Short Quote' }}</label>
                <textarea name="bio" required style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--panel-border); color: #fff; padding: 0.75rem 1rem; border-radius: 8px; font-family: inherit; transition: 0.3s; box-sizing: border-box; resize: vertical;" rows="3" onfocus="this.style.borderColor='var(--accent-cyan)'" onblur="this.style.borderColor='var(--panel-border)'">{{ $user->bio ?? '' }}</textarea>
            </div>
            
            <button type="submit" style="width: 100%; background: var(--accent-cyan); color: #000; border: none; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 0.5rem; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 20px rgba(0, 217, 255, 0.5)'" onmouseout="this.style.boxShadow='none'">
                {{ $lang === 'id' ? 'SIMPAN PERUBAHAN PROFIL' : 'SAVE PROFILE CHANGES' }}
            </button>
        </form>
    </div>

    <!-- Kolom Kanan: Keamanan Tambahan -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- SSO Google Integration -->
        <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin: 0 0 1rem 0; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#eab308" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l8.29-8.29c.94-.94.94-2.48 0-3.42L12 2Z"></path><path d="M7 7h.01"></path></svg>
                {{ $lang === 'id' ? 'Integrasi Sistem SSO' : 'SSO System Integration' }}
            </h3>
            
            @if($user->google_id)
                <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem;">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Google Avatar" style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid #22c55e;">
                    @else
                        <div style="width: 48px; height: 48px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-weight: bold; font-size: 1.2rem;">G</div>
                    @endif
                    <div>
                        <div style="color: #22c55e; font-weight: 800; font-size: 0.95rem;">{{ $lang === 'id' ? 'Akun Google Tertaut' : 'Google Account Linked' }}</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; font-family: monospace;">{{ $user->email }}</div>
                    </div>
                </div>
                
                <form action="{{ route('auth.google.unlink') }}" method="POST" onsubmit="confirmDestructiveAction(event, this, '{{ $lang }}', 'Warning: Unlinking Google SSO will force you to use manual password login in the future. Continue?', 'Peringatan: Melepaskan tautan Google SSO akan memaksa Anda login menggunakan Sandi manual ke depannya. Lanjutkan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 100%; background: transparent; color: #ef4444; border: 1px solid #ef4444; padding: 0.75rem; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'" onmouseout="this.style.background='transparent'">
                        {{ $lang === 'id' ? 'PUTUSKAN TAUTAN GOOGLE SSO' : 'UNLINK GOOGLE SSO' }}
                    </button>
                </form>
            @else
                <div style="background: rgba(255, 255, 255, 0.02); border: 1px dashed rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" style="margin-bottom: 0.5rem;"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l8.29-8.29c.94-.94.94-2.48 0-3.42L12 2Z"></path><path d="M7 7h.01"></path></svg>
                    <div style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">
                        {{ $lang === 'id' ? 'Akun Anda saat ini belum tertaut dengan Sertifikat Keamanan Google Kampus (SSO).' : 'Your account is not currently linked with Campus Google Security Certificate (SSO).' }}
                    </div>
                </div>
                
                <a href="{{ route('google.login') }}" style="display: block; width: 100%; background: #fff; color: #000; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 800; cursor: pointer; transition: 0.3s; text-decoration: none; text-align: center; box-sizing: border-box;" onmouseover="this.style.boxShadow='0 0 15px rgba(255, 255, 255, 0.5)'" onmouseout="this.style.boxShadow='none'">
                    <span style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="18px" height="18px"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                        {{ $lang === 'id' ? 'TAUTKAN KREDENSIAL GOOGLE' : 'LINK GOOGLE CREDENTIALS' }}
                    </span>
                </a>
            @endif
        </div>

        <!-- Ubah Sandi -->
        <div style="background: rgba(10, 16, 22, 0.5); border: 1px solid var(--panel-border); border-radius: 1rem; padding: 1.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin: 0 0 1rem 0; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                {{ $lang === 'id' ? 'Perbarui Keamanan Sandi' : 'Update Password Security' }}
            </h3>
            
            <form action="{{ route('student.password.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf
                <div style="position: relative;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">{{ $lang === 'id' ? 'Sandi Saat Ini' : 'Current Password' }}</label>
                    <input type="password" id="currentPassword" name="currentPassword" required style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--panel-border); color: #fff; padding: 0.75rem 2.5rem 0.75rem 1rem; border-radius: 8px; font-family: inherit; transition: 0.3s; box-sizing: border-box;" onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='var(--panel-border)'">
                    <button type="button" onclick="togglePassword('currentPassword', this)" style="position: absolute; right: 10px; bottom: 10px; background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0; outline: none; transition: 0.3s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--text-muted)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
                <div style="position: relative;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">{{ $lang === 'id' ? 'Sandi Baru' : 'New Password' }}</label>
                    <input type="password" id="newPassword" name="newPassword" required minlength="8" style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--panel-border); color: #fff; padding: 0.75rem 2.5rem 0.75rem 1rem; border-radius: 8px; font-family: inherit; transition: 0.3s; box-sizing: border-box;" onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='var(--panel-border)'">
                    <button type="button" onclick="togglePassword('newPassword', this)" style="position: absolute; right: 10px; bottom: 10px; background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0; outline: none; transition: 0.3s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--text-muted)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
                <div style="position: relative;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">{{ $lang === 'id' ? 'Konfirmasi Sandi Baru' : 'Confirm New Password' }}</label>
                    <input type="password" id="newPasswordConfig" name="newPassword_confirmation" required minlength="8" style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--panel-border); color: #fff; padding: 0.75rem 2.5rem 0.75rem 1rem; border-radius: 8px; font-family: inherit; transition: 0.3s; box-sizing: border-box;" onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='var(--panel-border)'">
                    <button type="button" onclick="togglePassword('newPasswordConfig', this)" style="position: absolute; right: 10px; bottom: 10px; background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0; outline: none; transition: 0.3s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--text-muted)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
                
                <button type="submit" style="width: 100%; background: transparent; color: #ef4444; border: 1px solid #ef4444; padding: 1rem; border-radius: 8px; font-weight: 900; letter-spacing: 0.1em; cursor: pointer; margin-top: 0.5rem; transition: 0.3s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'" onmouseout="this.style.background='transparent'">
                    {{ $lang === 'id' ? 'UBAH KATA SANDI' : 'CHANGE PASSWORD' }}
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, btnParams) {
        const input = document.getElementById(inputId);
        const isPassword = input.type === 'password';
        
        if (isPassword) {
            input.type = 'text';
            btnParams.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
        } else {
            input.type = 'password';
            btnParams.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
        }
    }
</script>
@endpush
