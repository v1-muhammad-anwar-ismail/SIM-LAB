# Referensi Arsitektur Spesifik: Role Admin Sistem (Super Admin)

Berdasarkan bedah dokumen **SRS_Sistem_Informasi_Manajemen_Laboratorium_Kelompok1_TIE24.pdf** (Bab 4.5 & 4.7), peran **Admin Sistem** diciptakan sebagai pemegang kekuasaan absolut (*Top Tier*) dalam konstelasi arsitektur perangkat lunak SIM-LAB. Berbeda dengan Master Lab yang kekuasaannya dibatasi oleh *"wilayah teritorial lab tertentu"*, Admin Sistem memiliki hak veto global tanpa terikat laboratorium fisik.

## 1. Daftar Halaman Rencana (Views & Tabs)
Tab navigasi dan akses UI untuk Admin Sistem (merujuk pada standar `layouts.admin` kita):
- **`overview`**: Pusat Komando Global (Global Command Center). Ikhtisar metrik tertinggi sistem (Total User aktif, Distribusi Role, Beban Sever/Database).
- **`users`**: Manajemen Entitas (User Management). Terminal utuh untuk pendaftaran, penghapusan, dan pemblokiran akun.
- **`roles`**: Hirarki Hak Akses (Role Access Control). Terminal terpisah/menyatu untuk merombak pangkat (*switch role*), seperti menaikkan status *mahasiswa* menjadi *dosen* atau sebaliknya.
- **`logs`**: Rekam Jejak Sistem (System Radar). Memantau detak nadi _Log Aktivitas_ global dari semua pengguna untuk forensik jika terjadi kejanggalan.
- **`settings`**: Profil Akun Pribadi Admin.

## 2. Alur Logika (Use Case) Utama
*(Berdasarkan Bab 4.7 Pengelolaan Sistem oleh Admin)*

- **Alur Regulasi Akun (Account Regulation):** 
  `Login` ➜ `Users Management` ➜ Admin memverifikasi, menambah, atau membuang populasi entitas dari struktur *database*.
- **Alur Perputaran Jabatan (Role Shifting):** 
  `Login` ➜ `Role Management` ➜ Admin memberikan medali jabatan (Master, Asisten, Dosen) ke akun-akun reguler agar mereka bisa mengakses pintu-pintu khusus.
- **Alur Forensik (System Audit):**
  `Login` ➜ `Logs/Monitoring` ➜ Melacak siapa yang mengubah data apa di lab mana (Pendeteksian aktivitas ilegal atau _bug_ tersembunyi).

## 3. Functional Requirements (FR) Spesifik Sistem Admin
Merujuk titik kordinat SRS:
- **FR-13 (Kelola Pengguna):** Admin secara absolut mengontrol CRUD (Buat, Baca, Utak-atik, Hapus) pada seluruh entitas di tabel `users`.
- **FR-14 (Kelola Hak Akses):** Memodifikasi hierarki kepangkatan entitas yang terdaftar (*mahasiswa, asisten, master, dosen, admin_sistem*).
- **Tersirat FR-xx (Global Monitoring):** Menjaga keteraturan dengan log jejak gerak-gerik seluruh pangkalan.

## 4. Filosofi Desain Antarmuka
Mengingat ini adalah role paling berbahaya (bisa menghapus siapa saja), desainnya akan mengadopsi tema **"God Mode / Central Intelligence"**:
- Akses dan konfirmasi ganda *(Double Authentication / Strict Modal)* pada tiap-tiap aksi pelepasan / penghapusan data.
- UI yang sangat berfokus pada kepadatan data (Tabel matriks besar) dibanding elemen grafis semata.
