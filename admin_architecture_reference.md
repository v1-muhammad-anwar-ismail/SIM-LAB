# Arsitektur Tata Kelola & Otoritas Sistem Admin (SIM-LAB)

Dokumen ini adalah referensi cetak biru untuk perancangan **Pusat Komando Back-Office** SIM-LAB UNESA yang mengacu secara pakem pada Spesifikasi Kebutuhan Perangkat Lunak (_Software Requirements Specification_ - Laporan RPL 2026).

## Landasan Arsitektural (Koreksi Otoritas)

Di dalam ekosistem SIM-LAB yang direkayasa berdasarkan bisnis logika asli, entitas `admin` bukanlah _stakeholder_ fungsional operasional. Berdasarkan dokumen SRS, pengendalian siklus hidup laboratori terbagi atas **3 pilar pengguna staf**, yaitu:

1. **Aslab (Asisten Laboratorium)**
2. **Master Lab (Kepala Laboratorium / Laboran Pusat)**
3. **Dosen (Pengampu Kegiatan)**

Laman _dashboard_ yang akan dibangun kelak bukanlah "Dashboard Admin", melainkan **Pusat Komando Staf** dengan desain terpadu. Sistem akan mengenali siapa yang melakukan _Log In_, dan menerapkan _Role-Based Access Control (RBAC)_ untuk menampilkan instrumen visual dan level otorisasi yang berbeda secara otomatis.

---

## 1. Asisten Laboratorium (Aslab)

**Peran:** Pelaksana Operasional Ujung Tombak. (Operator Harian).

> [!NOTE]
> Aslab adalah pihak yang secara fisik bertemu dengan mahasiswa di titik serah & kembali alat. Mereka adalah operator inventori paling aktif.

**Lingkup Antarmuka (UI Scope):**

- **Verifikasi Tahap Pertama:** Melakukan persetujuan awal (Acc) atau penolakan pengajuan alat yang masuk.
- **Handover Interface:** Memiliki tombol "Serahkan Alat" (mengubah status dari `Disetujui` menjadi `Dipinjam`).
- **Return Interface:** Memiliki form konfirmasi penerimaan alat kembali berserta form kondisional untuk mencatat _kerusakan_ atau _denda_ apabila mahasiswa telat mengembalikan.
- **Inventory Minor:** Update ketersediaan alat, menambah foto alat (jika diizinkan Master).

## 2. Master Lab (Kalab)

**Peran:** Pengendali Tertinggi Laboratorium & Sistem.

> [!IMPORTANT]
> Master Lab berada pada puncak piramida otoritas domain laboratorium. Mereka adalah tuhan dari mesin ini karena mampu membatalkan paksa hingga membatasi akses ruang/alat tertentu.

**Lingkup Antarmuka (UI Scope):**

- **Analitik Kritis:** Mengakses dasbor analitik makro terkait lalu lintas penggunaan alat terlengkap (grafik peminjaman semesteran/bulanan).
- **Hard Override:** Mampu membatalkan (Reject) paksa peminjaman yang meskipun telah di-ACC oleh Aslab, atau bahkan memblokir/membanned (_suspend_) akun mahasiswa pelanggar.
- **Manajemen Modul Pokok:** Membuat Ruang Laboratorium baru, memanajemen data Staf Aslab, menunjuk Dosen, hingga memodifikasi limit pengajuan mahasiswa.

## 3. Dosen Pengampu

**Peran:** Validasi & _Sponsorship_ Kegiatan Akademis.

> [!TIP]
> Fitur Dosen hanya menyala jika "Skema Peminjaman" menuntut kewajiban disposisi Dosen (seperti Peminjaman Ruang Lab untuk kegiatan matakuliah terkait).

**Lingkup Antarmuka (UI Scope):**

- **Sistem Disposisi:** Laman yang sangat minimalis (berbentuk Tabel _Card_ validasi masuk) di mana mereka hanya diberi tombol centang Hijau (ACC) atau Silang Merah (TOLAK) pada pengajuan yang menyematkan nama mereka sebagai penanggung jawab materi/kegiatan kelas.

---

## Kesepakatan Teknis

- Seluruh tipe Staf (`asisten`, `master`, `dosen`) di dalam sistem registrasi pangkalan data (`users` table) akan berbagi **Satu Endpoint Routing Akses Utama**, yaitu `/staff/dashboard` atau `/admin/dashboard`.
- Middleware dan _View Renderer_ akan melucuti elemen yang tidak boleh dilihat oleh peran yang lebih rendah (misalnya: menu _"Hapus Laboratorium"_ tidak akan termuat di layar Aslab).
- Penggunaan estetika panel administrasi ini akan diselaraskan dengan _Cyberpunk UX_ mahasiswa, namun dengan corak warna palet sekunder (misal: _Cyber Yellow_ atau _Matrix Green_) guna memberikan penanda psikologis yang tegas bahwa pengguna tersebut berada di ranah Pengendalian Sistem, bukan ranah Konsumen (Mahasiswa).
