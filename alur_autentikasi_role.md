# Alur Autentikasi dan Manajemen Peran (Role) SIM-LAB

Dokumen ini memuat standar baku mengenai mekanisme *Login*, *Registrasi*, dan tata kelola Hak Akses (*Role*) lintas pengguna dalam Sistem Informasi Manajemen Laboratorium (SIM-LAB) berdasarkan spesifikasi `Laporan RPL 2026.pdf`.

Dokumen ini **wajib dijadikan landasan utama** dalam setiap pengembangan modul _Authentication_, _Middleware_, serta pembuatan akun (_Seeding_) di dalam repositori sistem.

---

## 1. Mekanisme Login Utama
Sistem SIM-LAB mengadopsi mekanisme *multi-user login* (FR-01) menggunakan gerbang terpusat (satu halaman login untuk semua peran).
- **Kredensial Autentikasi Baku:** Kombinasi **Email** dan **Password**.
- **Alasan Penggunaan Email:** Mempermudah mekanisme pemulihan sandi (*forgot password*) jika pengguna kehilangan akses.

---

## 2. Kebijakan Registrasi (Pendaftaran) dan Penugasan (*Role Assignment*)

Guna memproteksi integritas pangkalan data dari pendaftar asing yang mencoba mendapatkan previlese tinggi, pendaftaran disekat secara ketat berdasarkan tingkatan peran. Jangan pernah mengekspos pilihan hak akses (*role selector*) seperti `Dosen` atau `Admin` pada formulir pendaftaran awam.

### A. MAHASISWA (Self-Registration)
- **Status Registrasi:** `Terbuka Publik`
- **Mekanisme:** Mahasiswa dipercayakan untuk mendata diri secara mandiri melalui *Public Register Page*.
- **Parameter Input (*Required*):** `Nama Lengkap`, `Email`, `Nomor Induk / NIM` (merujuk ke kolom `nomor_induk`), dan `Password`.
- **Ekspektasi Sistem:** Sesaat setelah formulir diserahkan, sistem secara eksklusif (otomatis) *hardcode* nilai kolom `role` mereka menjadi `mahasiswa`.

### B. DOSEN & MASTER LABORATORIUM (Admin Assignment)
- **Status Registrasi:** `Tertutup`
- **Mekanisme:** Mengingat peran ini krusial dalam menyetujui peminjaman (Approval), mereka tidak diperbolehkan mendaftar mandiri. Akun ini hanya dapat ditambahkan (diciptakan) dari panel interior oleh **Admin Sistem**.
- **Parameter Unik:** Menggunakan **NIP** atau **NIDN** yang direkam ke dalam kolom `nomor_induk`.
- **Skenario Alternatif:** Apabila Dosen terpaksa harus mendaftar via _Public Register Page_, maka akun defaultnya akan menjadi `mahasiswa`. **Admin Sistem** secara manual (via fungsi Kelola Akses / FR-14) akan merubah perannya ('di-upgrade') menjadi `dosen` atau `master`.

### C. ASISTEN LABORATORIUM / ASLAB (Admin Assignment)
- **Status Registrasi:** `Tertutup`
- **Mekanisme:** Memiliki previlese mutlak dalam pengelolaan aset fisik (`alat`), asisten laboratorium ditugaskan sepenuhnya berdasarkan restu Admin/Master. 
- **Opsi Pemberian Akses:** 
  1. Seorang Mahasiswa biasa yang lolos rekrutmen ASLAB akan di-upgrade `role`-nya dari `mahasiswa` menjadi `asisten` oleh Admin dari *Dashboard*.
  2. Admin membagikan akun turunan secara langsung pada individu asisten baru.

### D. ADMIN SISTEM (God Mode / System Seed)
- **Status Registrasi:** `Paten (Hardcoded / Seeded)`
- **Mekanisme:** Tentu menjadi kontradiksi jika *Super User* (pengendali tunggal sistem) bisa dibuat melalui form pendaftaran. Akun Admin generasi pertama ini **wajib diselundupkan (di-seed) secara statis** melalui *Database Seeder* dari ranah *development backend*.
- **Ekspektasi Sistem:** `admin@simlab.unesa.ac.id` dengan Password yang di-hash yang bertugas mengeksekusi kendali Manajemen Pengguna.

---

## 3. Garis Ringkasan Arsitektur Keamanan
> [!WARNING]
> Sangat Terlarang: Menyisipkan elemen "Tipe Akun" (*Role Dropdown Option*) pada `form` registrasi publik yang rawan dieksploitasi oleh pihak luar demi mendapatkan akses administrasi.

**Alur Teknis Developer:**
1. Desain **1 Halaman Login**.
2. Desain **1 Halaman Register** spesifik berprioritas input **NIM** untuk mencetak otomatis *Role* Mahasiswa.
3. Ciptakan **1 Database Seeder** rahasia yang melahirkan Akun Admin Orisinil.
4. Desain **Fungsi Kelola Pengguna (Dashboard Admin)** khusus bagi Admin Orisinil untuk mulai mengangkat Dosen, Master, dan Asisten Lab resmi.
