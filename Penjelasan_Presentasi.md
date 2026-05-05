# Panduan dan Naskah Presentasi Proyek SIM-LAB
*(Tidak Termasuk Functional Requirements / FR)*

Dokumen ini berisi panduan dan draf penjelasan untuk 4 anggota kelompok (selain bagian FR) agar presentasi berjalan runtut, jelas, dan mudah dipahami oleh audiens.

---

## 1. PEMBICARA PERTAMA (Anggota 2): Pendahuluan & Aktor Pengguna
**Tugas:** Membuka presentasi, menjelaskan masalah yang diangkat, dan siapa saja pengguna aplikasi ini.

**Poin Penjelasan (Bisa dibaca/dimodifikasi saat bicara):**
*   **Latar Belakang & Masalah:** 
    *   Sistem manajemen laboratorium saat ini masih memiliki banyak celah karena beberapa proses dilakukan secara manual.
    *   Sering terjadi ketidakteraturan jadwal (bentrok penggunaan ruangan/alat).
    *   Tidak ada rekap data yang jelas mengenai ketersediaan dan riwayat alat, sehingga rentan terjadi kehilangan atau kerusakan barang yang tidak terlacak.
*   **Solusi & Tujuan (SIM-LAB):**
    *   Hadirnya SIM-LAB (Sistem Informasi Manajemen Laboratorium) adalah untuk mendigitalkan seluruh proses tersebut ke dalam satu sistem terpusat berbasis *web*.
    *   Tujuannya sangat jelas: membuat operasional laboratorium menjadi **transparan**, **efisien**, dan **termonitor** dengan baik.
*   **Aktor Pengguna (Siapa yang pakai?):** Terdapat 5 peran (*Role*) dalam sistem ini:
    1.  **Mahasiswa:** Pengguna utama yang meminjam alat/ruang.
    2.  **Asisten Laboratorium:** Pihak yang memvalidasi pengajuan awal dan memeriksa kondisi fisik alat saat dipinjam maupun dikembalikan.
    3.  **Master Laboratorium:** Bertanggung jawab penuh atas ketersediaan inventaris dan yang memberikan persetujuan (approval) akhir peminjaman.
    4.  **Dosen:** Pihak yang memonitor pemakaian lab dan melihat statistik laporan melalui *dashboard* analitik.
    5.  **Admin Sistem:** Mengelola data *master* pengguna, hak akses, dan aktivitas global.

---

*(Setelah Anggota 2 selesai, giliran Anggota 1 untuk menjelaskan detail FR/Fitur-fiturnya)*

---

## 2. PEMBICARA KETIGA (Anggota 3): Pemodelan Sistem & Alur Kerja
**Tugas:** Jika anggota 1 menjelaskan *apa saja fiturnya*, anggota 3 bertugas menjelaskan *bagaimana fitur itu bekerja secara sistem* menggunakan *Use Case* / *Activity Diagram*.

**Poin Penjelasan:**
*   **Use Case Diagram (Gambaran Interaksi Global):**
    *   Jelaskan bahwa sistem dirancang agar setiap aktor memiliki porsinya masing-masing. Mahasiswa hanya berinteraksi pada modul pencarian jadwal dan form peminjaman. Sementara staf lab (Asisten & Master) difokuskan pada modul *approval* dan validasi barang. Dosen memiliki akses pemantauan (view only pada rekap), dan Admin memegang kendali modul konfigurasi keseluruhan.
*   **Alur Kerja Utama (Contoh: Peminjaman Alat/Ruang):**
    *   (Tunjuk Activity Diagram yang paling krusial di presentasi).
    *   *"Bisa kita lihat pada alur utama peminjaman, prosesnya sangat sistematis. Dimulai ketika mahasiswa login. Sebelum meminjam, mahasiswa diwajibkan mengecek jadwal di halaman Buku Antrean Global agar tahu waktu yang kosong. Jika jadwal aman, mahasiswa mengajukan form. Sistem otomatis memvalidasi apakah ada jadwal bentrok.*
    *   *Jika aman, pengajuan masuk ke Asisten Lab, diteruskan ke Master Lab untuk di-approve. Saat alat dikembalikan, Asisten wajib mengecek kondisi fisik alat apakah rusak atau baik, baru status peminjaman dinyatakan selesai."*

---

## 3. PEMBICARA KEEMPAT (Anggota 4): Kebutuhan Non-Fungsional (NFR) & Arsitektur
**Tugas:** Menjelaskan spesifikasi teknis dan jaminan kualitas sistem (bukan sekadar fitur).

**Poin Penjelasan:**
*   **Kebutuhan Non-Fungsional (NFR):** Menjelaskan bahwa sistem ini dibuat untuk memenuhi standar kualitas *software*.
    *   **Keamanan (Security):** Sistem dilengkapi autentikasi ketat dengan pola *Role-Based Access Control* (RBAC). Mahasiswa tidak akan bisa menembus masuk ke *dashboard* persetujuan Master Lab, sehingga kerahasiaan dan integritas data terjamin.
    *   **Performa & Transparansi Real-Time:** Sistem dirancang agar pembaruan data stok dan jadwal di *Buku Antrean Global* terjadi secara instan (real-time). Ini sangat penting untuk menghindari *double booking* jika ada dua orang yang meminjam di waktu bersamaan.
    *   **Usability (Kenyamanan Pengguna):** Karena penggunanya beragam dari mahasiswa hingga staf, UI dibuat modern, informatif, dan mudah dipahami walau tanpa buku panduan yang tebal.
*   **Arsitektur & Basis Data:**
    *   Berbasis Web sehingga bisa diakses dari *device* apa saja.
    *   *Database* dirancang secara relasional yang mengikat erat antara data Alat, Peminjam, dan Riwayat Waktu sehingga jejak peminjaman tidak bisa hilang atau diakali.

---

## 4. PEMBICARA KELIMA (Anggota 5): Antarmuka Pengguna (UI) & Kesimpulan
**Tugas:** Menampilkan *showcase* / demo visual dari sistem, merangkum keseluruhan, dan menutup presentasi.

**Poin Penjelasan:**
*   **Showcase UI (Membahas halaman `/schedule` & lainnya):**
    *   Tampilkan desain layar utama (*screenshot*).
    *   *"Inilah perwujudan dari apa yang kami rancang. Sebagai contoh pada halaman **Buku Antrean Global**, di sini kami memberikan transparansi penuh kepada seluruh pengguna. Mahasiswa bisa melihat riwayat lalu-lintas reservasi yang sedang aktif dan melihat jadwal mana yang sudah diblokir, sehingga mereka bisa mengambil ancang-ancang waktu yang aman. Tidak akan ada lagi cerita lab penuh padahal status di jadwal kosong."*
*   **Kesimpulan:**
    *   *"Sebagai penutup, sistem SIM-LAB ini bukan sekadar aplikasi pencatatan peminjaman, melainkan solusi komprehensif (end-to-end) untuk membabat habis permasalahan birokrasi kertas, bentrok jadwal, dan alat hilang yang sering terjadi di laboratorium. Dengan ini, transparansi dan efisiensi lab kampus kita bisa ditingkatkan secara signifikan."*
*   **Sesi Akhir:**
    *   Menutup presentasi, mengucapkan terima kasih, dan mempersilakan dosen/audiens untuk sesi tanya jawab.
