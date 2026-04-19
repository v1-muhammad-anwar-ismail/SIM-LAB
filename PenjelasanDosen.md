# Referensi Arsitektur Spesifik: Role Dosen

Berdasarkan dokumen **SRS_Sistem_Informasi_Manajemen_Laboratorium_Kelompok1_TIE24.pdf**, peran **Dosen** (Dosen Umum) diciptakan untuk menjadi supervisor murni (Pemonitor). Dosen tidak memiliki hak prerogatif untuk melegitimasi / memvalidasi barang selayaknya Master Lab, dan juga tidak melakukan peminjaman seperti Mahasiswa. 

## 1. Daftar Halaman (Views & Tabs)
Tab navigasi dan akses UI untuk dosen:
- **`overview`**: Dashboard Dosen. Ikhtisar aktivitas hari ini.
- **`schedule`**: Jadwal Laboratorium. Menunjukan porsi ketersediaan ruangan agar riset/praktikum dosen spesifik tidak bentrok.
- **`monitoring`**: Monitoring Penggunaan. Peta status lab secara langsung (Real-time).
- **`analytics`**: Dashboard Analitik. Transformasi data peminjaman mentah ke statistik grafikal.
- **`settings`**: Profil Akun. Pengaturan biodata pribadi dosen.
- **Notifikasi**: Radar Peringatan via Dropdown Top-Bar.

## 2. Alur Logika (Use Case) Utama
*(Berdasarkan Bab 4.5.3 Monitoring & 4.5.7 Laporan)*

- **Alur Observasi (Monitoring):** 
  `Login` ➜ `Dashboard/Schedule/Monitoring` ➜ Cek kapasitas lab dan ketersediaan peralatan kritis sebelum membuat kurikulum.
- **Alur Rekap (Reporting):** 
  `Login` ➜ `Analytics/Laporan` ➜ Menarik data dari tumpukan ratusan riwayat untuk diolah menjadi bentuk yang terukur bagi keperluan akademik.

## 3. Functional Requirements (FR) Spesifik Dosen
- **FR-02**: Mampu melihat Jadwal Lab transparan.
- **FR-03**: Cek ketersediaan inventaris Real-time.
- **FR-08**: Mengakses informasi lewat Dashboard Analitik yang mudah dibaca (Grafik/Statistik).
- **FR-09**: Membuat & menarik Laporan Penggunaan (Download data export).

## 4. Non-Functional Requirements (NFR) Terkait Dosen
- **NFR-08 (Real-time)**: Semua diagram stok yang tayang di sistem dosen WAJIB sinkron satu pintu seketika saat Aslab memvalidasi persetujuan di detik yang sama, untuk menghindari pemesanan fiktif.
- **NFR-04 (Usability)**: Dosen mungkin memiliki kepekaan UI/UX yang konvensional, sehingga grafik analitik harus sesimpel dan seintuitif mungkin (High Readability).
- **NFR-01 (Performance)**: Query penarikan pelaporan tidak boleh memakan waktu lebih dari 3 detik meski server sedang menghimpun data 5 bulan terakhir.
