# Perbedaan Hierarki dan Kewenangan: Master Laboratorium vs Asisten Laboratorium

Berdasarkan analisis spesifikasi pada *Software Requirements Specification (SRS) Sistem Informasi Manajemen Laboratorium UNESA*, berikut adalah batas demarkasi dan logika hierarki operasional antara Master Laboratorium dan Asisten Laboratorium (Aslab):

## 1. Definisi Aktor & Struktur Kekuasaan
Menurut dokumen SRS, struktur hierarkinya secara absolut tidak selevel:

*   **Master Laboratorium (TIE Master):**
    *   **Deskripsi Pekerjaan:** Adalah seorang **Dosen** atau staf ahil yang menjabat sebagai Kepala Laboratorium.
    *   **Peran Utama:** Pemegang keputusan kebijakan (*Policy Maker*), penanggung jawab tertinggi di sebuah ruangan lab, dan pelapor hierarki tingkat lanjut (*Executive Reporter*).
    *   **Posisi:** **Teratas** di dalam lab tersebut (hanya tunduk pada Admin/Ketua Jurusan).

*   **Asisten Laboratorium (Aslab):**
    *   **Deskripsi Pekerjaan:** Biasanya dijabat oleh **Mahasiswa** tingkat atas yang direkrut menjadi staf asisten paruh waktu.
    *   **Peran Utama:** Merupakan **Pelaksana Operasional** (garda terdepan lapangan).
    *   **Posisi:** **Bawahan langsung** dari Master Laboratorium. Merekalah yang melayani pembukaan pintu, pengecekan kabel, dan verifikasi barang nyata.

## 2. Pengecualian Hierarki Bersilang (*Cross-Functional Approval*) pada Form Peminjaman
Poin 5 & 6 pada dokumen SRS ("Asisten laboratorium **atau** Master Laboratorium menyetujui transaksi...") memang mendesain hak level *"Equal"* (setara), namun ini **hanya eksklusif berlaku untuk Fitur Kotak Masuk Persetujuan Peminjaman Mahasiswa**. 

**Mengapa desain sistem direkayasa demikian?**
Tujuannya murni untuk menghindari **Hambatan Administrasi (Bottleneck)**.
Dosen (Master Lab) dituntut sibuk dengan agenda penelitian, tri-dharma, dan mengajar. Sangat tidak efisien apabila sebuah proses pinjam-meminjam sebuah *mouse* atau ruang *networking* selama sejam harus mandek berhari-hari hanya demi menunggu dosen menekan tombol *Klik Setuju* di dasbor.
Maka dari itu, Aslab diberikan delegasi kekuasaan potong-kompas agar dapat meninjau, mengubah status, dan meloloskan penyerahan alat sekecepatan instan tanpa mengganggu rutinitas Master Lab. Meski demikian, Master Lab tetap bisa menyetujuinya sendiri apabila ia yang sedang membuka sistem dan Aslab berhalangan hadir.

## 3. Fitur Eksklusif Master Laboratorium (Hak Istimewa)
Karena Master Laboratorium berada pada rantai makanan yang tertingg, Dasbor Master memuat dua kekuatan besar yang *haram* dan *tidak boleh diakses* oleh Dasbor Asisten Laboratorium:
1.  **Hak Manajemen Sumber Daya Manusia (HRD):** Hak konstitusional di mana **Master Lab bebas mengangkat *(hire)* mahasiswa sebagai Aslab**, atau **memecat *(fire)* Aslab** jika kinerja pelaporan lapangan mereka buruk.
2.  **Akses Intelijen Laporan Demografi & Keuangan (High-Level Report):** Master Lab memiliki kapabilitas mencetak laporan audit, intensitas peminjaman tingkat tinggi, dan perhitungan nilai perusakan/denda kerusakan aset sebagai bahan laporan kepada Ketua Jurusan/Superaktif Admin.

> Catatan ini menjadi standar kepatuhan logika (*Standard Logical Complicance*) ketika membangun atau menyingkirkan fitur di aplikasi SIM-LAB ke depannya.
