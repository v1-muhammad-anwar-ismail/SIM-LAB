# Panduan dan Naskah Presentasi Proyek SIM-LAB (Sistem Informasi Manajemen Laboratorium)
*(Dokumen ini berisi draf naskah presentasi mendalam untuk 4 anggota kelompok, di luar bagian Functional Requirements / FR)*

---

## 1. PEMBICARA PERTAMA (Anggota 2): Pendahuluan, Latar Belakang & Analisis Aktor
**Tugas:** Sebagai pembuka jalannya presentasi, tugas Anda adalah "menjual" ide aplikasi ini. Anda harus membuat audiens (dan dosen) sadar betapa krusialnya masalah di lab saat ini, dan mengapa aplikasi ini adalah solusi terbaik.

**Naskah & Poin Penjelasan Detail:**

*   **Pembukaan & Hook (Menarik Perhatian):**
    *   *Naskah:* "Selamat pagi/siang. Pernahkah Anda mengalami situasi di mana Anda sudah jauh-jauh datang ke laboratorium kampus untuk mengerjakan tugas, namun ternyata lab tersebut sedang dipakai untuk praktikum kelas lain karena tidak ada jadwal yang jelas? Atau, pernahkah pihak lab kebingungan mencari inventaris alat yang hilang karena buku catatan peminjaman kertasnya terselip entah ke mana? Inilah realita operasional laboratorium kita saat ini yang masih bergantung pada metode konvensional."

*   **Identifikasi Masalah (Latar Belakang):**
    *   **Birokrasi yang Lambat:** Proses meminjam alat atau ruangan memerlukan banyak tanda tangan fisik, dari asisten lab hingga dosen pengampu, yang memakan waktu berhari-hari.
    *   **Double Booking (Jadwal Bentrok):** Tidak adanya satu papan informasi jadwal terpadu (*Single Source of Truth*) membuat sering terjadinya bentrok antara mahasiswa yang ingin riset mandiri dengan jadwal praktikum reguler.
    *   **Kehilangan & Kerusakan Aset Tak Terlacak:** Pengecekan alat seringkali luput. Saat alat rusak, tidak ada bukti siapa peminjam terakhir yang harus bertanggung jawab.

*   **Solusi Kami: SIM-LAB:**
    *   *Naskah:* "Oleh karena itu, kami mengembangkan SIM-LAB. Sebuah *platform web* terintegrasi yang mendigitalkan seluruh rantai operasional lab. Dari hulu (pengajuan jadwal) hingga hilir (pengembalian barang dan laporan kerusakan)."

*   **Analisis Aktor Pengguna (Role-Based Access):**
    *   Sistem ini tidak hanya melayani satu jenis pengguna, melainkan 5 tingkat *role* dengan otorisasi yang berbeda demi keamanan:
        1.  **Mahasiswa (End-User):** Fokusnya hanya pada layanan peminjaman. Mereka bisa mengecek jadwal secara *real-time*, mengajukan pinjaman alat/ruang, dan melihat status *approval* mereka (apakah disetujui atau ditolak).
        2.  **Asisten Laboratorium (First-Line Validator):** Bertugas di lapangan. Mereka memvalidasi apakah alat yang mau dipinjam kondisinya bagus, dan mengecek kembali kondisinya saat alat dikembalikan.
        3.  **Master Laboratorium (Decision Maker):** Pihak yang memegang hak *approval* mutlak. Mereka yang mengeksekusi apakah pengajuan mahasiswa bisa dilanjutkan atau ditolak berdasarkan ketersediaan persediaan.
        4.  **Dosen (Monitor & Evaluator):** Tidak ikut dalam proses peminjaman, melainkan memiliki *dashboard* khusus berupa analitik dan grafik untuk memantau utilitas lab (seberapa sering lab dipakai, alat apa yang paling sering dipinjam).
        5.  **Admin Sistem (Super User):** Mengatur penambahan data dosen baru, sinkronisasi *database* aset master, dan konfigurasi inti sistem.

---

*(Setelah Anggota 2 selesai, Anggota 1 akan maju untuk membedah Functional Requirements / Fitur detail aplikasi)*

---

## 2. PEMBICARA KETIGA (Anggota 3): Pemodelan Sistem & Alur Kerja (UML)
**Tugas:** Teman sebelumnya sudah membahas fitur (FR). Kini giliran Anda menjelaskan *BAGAIMANA* secara logika sistem fitur tersebut saling terhubung satu sama lain menggunakan pendekatan UML.

**Naskah & Poin Penjelasan Detail:**

*   **Transisi dari FR ke Pemodelan:**
    *   *Naskah:* "Menyambung dari fitur-fitur yang sudah dijelaskan, pertanyaan selanjutnya adalah: bagaimana sistem ini mengatur lalu-lintas data dari ribuan mahasiswa tanpa *error*? Kita akan melihatnya dari Use Case Diagram."

*   **Bedah Use Case Diagram:**
    *   Arahkan perhatian audiens ke diagram. Jelaskan "batasan sistem" (*system boundary*).
    *   *Naskah:* "Bisa dilihat di diagram ini, kita memisahkan otorisasi dengan tegas. Mahasiswa memiliki garis interaksi langsung ke *Use Case* 'Lihat Jadwal' dan 'Ajukan Peminjaman'. Perhatikan bahwa Mahasiswa tidak memiliki akses ke *Use Case* 'Validasi Pengembalian'. Akses ini mutlak hanya ditarik garisnya ke Asisten Lab. Ini menjamin mahasiswa tidak bisa memanipulasi status pengembalian barangnya sendiri."

*   **Activity Diagram (Alur Kerja Eksekusi Peminjaman):**
    *   Gunakan teknik *Storytelling* (bercerita) langkah demi langkah.
    *   **Fase 1 (Inisiasi):** "Alur dimulai saat Mahasiswa login. *Action* pertama yang diwajibkan sistem adalah Mahasiswa harus mengecek Buku Antrean Global. Jika alat tidak tersedia, sistem otomatis memblokir form pengajuan (*decision node*)."
    *   **Fase 2 (Validasi Multi-Layer):** "Jika alat *available*, mahasiswa men-submit form. Data masuk ke *dashboard* Asisten Lab. Asisten mengecek fisik di lemari. Jika alat rusak, asisten menekan tombol tolak (Sistem memberi notifikasi penolakan ke mahasiswa). Jika alat bagus, asisten menekan teruskan."
    *   **Fase 3 (Persetujuan Akhir):** "Form yang lolos asisten akan masuk ke Master Lab untuk *final approval*. Di sinilah status di database berubah menjadi 'Sedang Dipinjam' dan jadwal otomatis memblokir waktu tersebut untuk mahasiswa lain."
    *   **Fase 4 (Penyelesaian):** "Siklus ditutup ketika barang dikembalikan. Asisten wajib memvalidasi kondisi akhir. Jika kembali dalam kondisi rusak, sistem akan membangkitkan 'Laporan Kerusakan' untuk ditindaklanjuti."

---

## 3. PEMBICARA KEEMPAT (Anggota 4): Kebutuhan Non-Fungsional (NFR) & Arsitektur Database
**Tugas:** Membuktikan bahwa aplikasi ini tidak hanya "bisa jalan", tapi juga dirancang secara kokoh, aman, dan dapat diandalkan (*Reliable*). 

**Naskah & Poin Penjelasan Detail:**

*   **Kebutuhan Non-Fungsional (Membangun Kualitas Sistem):**
    *   *Naskah:* "Aplikasi yang memiliki banyak fitur akan percuma jika sering *down* atau mudah diretas. Oleh karena itu, di luar kebutuhan fungsional, kami menetapkan metrik Non-Fungsional (NFR) yang ketat."
    *   **Security (Keamanan):** "Seluruh data *password* pengguna tidak disimpan dalam bentuk *plaintext*, melainkan dienkripsi. Kami juga menerapkan sesi *auto-logout* dan pencegahan *bypass URL* sehingga mahasiswa yang mencoba mengakses URL *dashboard* admin (`/admin-panel`) akan otomatis ditendang keluar oleh sistem."
    *   **Performance & Reliability (Performa):** "Halaman `/schedule` kami rancang dengan algoritma optimasi karena ia harus menarik data dari tabel relasi yang banyak. Tujuannya adalah memastikan status 'Alat Kosong' atau 'Ruang Terpakai' bersifat instan (*real-time synchronization*). Keterlambatan data beberapa detik saja dapat memicu *Double Booking* di lapangan."
    *   **Usability (Kenyamanan Pengguna):** "Mengingat Master Lab atau Dosen mungkin memiliki rentang usia yang tidak *tech-savvy*, antarmuka dibangun dengan panduan *Tooltips*, indikator warna (hijau untuk aman, merah untuk penuh), dan desain responsif yang bisa dibuka nyaman lewat *smartphone*."

*   **Arsitektur Sistem & Database (ERD):**
    *   Jelaskan secara garis besar bagaimana data saling mengunci.
    *   *Naskah:* "Dari sisi *Database*, kami merancang struktur *Entity Relationship*. Tabel **Peminjaman** berperan sebagai jantung transaksi yang berelasi (*Foreign Key*) dengan tabel **Pengguna** dan tabel **Inventaris**. Ini berarti, sistem memegang *log history* yang absolut. Jika 5 tahun ke depan kita ingin melacak mikroskop bernomor seri A1 rusak pada bulan apa dan siapa peminjam terakhirnya, sistem dapat melacaknya dalam hitungan detik."

---

## 4. PEMBICARA KELIMA (Anggota 5): Demonstrasi UI, Showcase, & Kesimpulan
**Tugas:** Menjadi penutup yang memukau. Visual adalah hal yang paling ditunggu audiens. Tugas Anda meyakinkan mereka melalui pameran *mockup* antarmuka dan menarik kesimpulan pamungkas.

**Naskah & Poin Penjelasan Detail:**

*   **UI Showcase (Menjelaskan Visual Aplikasi):**
    *   Tampilkan desain layar di proyektor (*Screenshot* atau prototipe Figma/Web).
    *   **Halaman Buku Antrean Global (`/schedule`):** 
        *   *Naskah:* "Mari kita lihat langsung hasil dari apa yang sudah kami rancang. Ini adalah halaman *Buku Antrean Global* atau Jadwal Umum. Halaman ini adalah senjata utama kami untuk mengedukasi transparansi. Di bagian *Reservation Timeline Status*, setiap pengguna bisa memantau lalu-lintas reservasi yang sedang aktif layaknya melihat jadwal penerbangan di bandara. Jika di sini berstatus merah/terblokir, tidak ada pengguna yang bisa memanipulasi peminjaman."
    *   **Dashboard Multi-Role:**
        *   *Naskah:* "Kami juga mengimplementasikan perbedaan tampilan. Di sebelah kiri adalah *dashboard* Dosen yang penuh dengan visualisasi grafik statistik persentase kerusakan dan frekuensi pemakaian lab. Di sebelah kanan adalah *dashboard* mahasiswa yang lebih minimalis, berfokus murni pada status pinjamannya sendiri."

*   **Kesimpulan (Wrap-Up):**
    *   *Naskah:* "Sebagai konklusi akhir, SIM-LAB bukan sekadar bentuk tugas digitalisasi form peminjaman dari kertas ke bentuk *web*. Ini adalah sebuah *Business Process Re-engineering* (Rekayasa Ulang Proses Bisnis). Dengan implementasi SIM-LAB, kita memangkas proses birokrasi berhari-hari menjadi hitungan menit, kita menghapus risiko hilangnya alat inventaris senilai puluhan juta karena keteledoran catatan manual, dan menciptakan harmoni penggunaan jadwal ruang lab. SIM-LAB memastikan bahwa operasional lab kampus kita melangkah menuju standar modern dan profesional."

*   **Penutup Sesi:**
    *   "Demikian rancangan dari kelompok kami. Terima kasih atas perhatian dosen pengampu dan rekan-rekan. Kami kembalikan kepada moderator atau membuka sesi diskusi dan tanya jawab."
