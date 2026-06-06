# SIM-LAB UNESA (Sistem Terminal Mahasiswa)

> **Platform Peminjaman dan Manajemen Laboratorium Terpadu Universitas Negeri Surabaya.**
> Proyek ini dibangun untuk mendigitalisasi proses peminjaman ruangan dan alat laboratorium.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/php-v8.5.4-purple.svg)
![Laravel](https://img.shields.io/badge/laravel-v11.x-red.svg)
![MySQL](https://img.shields.io/badge/database-MySQL-blue.svg)

## Deskripsi

**SIM-LAB UNESA** adalah platform web terpadu untuk mengelola inventaris, jadwal, dan peminjaman alat serta ruangan laboratorium di lingkungan Universitas Negeri Surabaya. Sistem ini memiliki peran (role) yang komprehensif mulai dari Mahasiswa, Asisten Laboratorium (ASLAB), Dosen, Master Lab, hingga Administrator Sistem. Sistem ini juga dilengkapi dengan antarmuka yang modern, dinamis, dan responsif (mengusung tema _Neon/Cyberpunk Aesthetic_).

---

## Fitur Utama

### Mahasiswa (Student):

- **Dashboard**: Papan utama informasi peminjaman dan ketersediaan lab.
- **Inventory Check**: Mengecek alat dan ruangan yang tersedia secara _real-time_.
- **Loan Request**: Formulir cerdas untuk mengajukan peminjaman fasilitas.
- **History Log**: Riwayat dan status pengajuan (Pending, Disetujui, Ditolak).

### Asisten Laboratorium (ASLAB):

- **Approvals**: Menyetujui atau menolak pengajuan peminjaman dari mahasiswa.
- **Inventory**: Manajemen data barang/alat laboratorium (Tambah, Edit, Hapus).
- **Returns**: Memantau dan mengelola pengembalian barang yang dipinjam.
- **Maintenance**: Pencatatan perbaikan dan pemeliharaan alat/ruangan.
- **Schedule**: Manajemen jadwal penggunaan lab.

### Dosen:

- **Monitoring**: Memantau seluruh aktivitas dan log penggunaan lab oleh mahasiswa/asisten.
- **Analytics Dashboard**: Statistik dan analitik penggunaan lab.
- **Laboratory Schedule**: Melihat jadwal penuh seluruh lab.

### Master Lab:

- **Laboratory Data**: Manajemen master data seluruh laboratorium.
- **ASLAB Management**: Menugaskan, memantau, dan mengelola asisten laboratorium.
- **Analytics Report**: Menarik data dan laporan lengkap kinerja laboratorium.

### Admin Sistem:

- **User Management**: Mengelola seluruh pengguna (mutasi hak akses, otorisasi).
- **Forensic Logs**: Radar forensik untuk seluruh sistem.

---

## Teknologi yang Digunakan

- **Backend**: PHP, Laravel 11
- **Frontend**: Blade Templating, Custom CSS (Cyberpunk Aesthetic)
- **Database**: MySQL
- **Dependencies Tambahan**: SweetAlert2 (Notifikasi), Toastify JS
- **Authentication**: Laravel Session & Google OAuth (SSO)

---

## Cara Menjalankan (Local Setup)

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

### 1. Clone Repository

```bash
git clone https://github.com/v1-muhammad-anwar-ismail/Project-UTS-RPL-2026.git
cd Project-UTS-RPL-2026
```

### 2. Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3. Konfigurasi Environment (.env)

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Lalu _generate_ _application key_:

```bash
php artisan key:generate
```

Sesuaikan konfigurasi database dan kredensial OAuth Anda di file `.env`:

```env
APP_NAME="SIM-LAB UNESA"
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simlab_db
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi Google OAuth (Jika menggunakan fitur Sign-in with Google)
GOOGLE_CLIENT_ID=client_id_anda
GOOGLE_CLIENT_SECRET=secret_anda
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 4. Migrasi dan Seeding Database

```bash
php artisan migrate:fresh --seed
```

### 5. Jalankan Server Lokal

```bash
php artisan serve
```

Buka browser dan akses URL: `http://localhost:8000`

---

## Screenshot Tampilan & Dokumentasi

Berikut adalah beberapa tampilan fitur dan halaman yang ada di dalam aplikasi **SIM-LAB UNESA**:

### Halaman Utama & Umum (Public Pages)

![Home Page 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/HomePage-1.png)
![Home Page 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/HomePage-2.png)
![Home Page 3](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/HomePage-3.png)
![About Us 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/AboutUsPage-1.png)
![About Us 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/AboutUsPage-2.png)
![About Us 3](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/AboutUsPage-3.png)
![About Us 4](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/AboutUsPage-4.png)
![About Us 5](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/AboutUsPage-5.png)
![Schedule Page](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/SchedulePage-1.png)
![Footer](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Footer.png)
![Login Page](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/LoginPage.png)

### Dashboard Mahasiswa (Student)

![Dashboard Student](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardStudentPage.png)
![Inventory Check](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardStudent-InventoryCheckPage.png)
![Loan Request 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardStudent-LoanRequestPage-1.png)
![Loan Request 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardStudent-LoanRequestPage-2.png)
![Loan Request 3](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardStudent-LoanRequestPage-3.png)
![Student History Log](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardStudent-HistoryLogPage.png)
![Student Account Profile](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardStudent-AccountProfilePage.png)

### Dashboard Asisten Lab (ASLAB)

![Dashboard ASLAB 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLABPage-1.png)
![Dashboard ASLAB 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLABPage-2.png)
![ASLAB Approval](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-ApprovalPage.png)
![ASLAB Inventory](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-InventoryPage.png)
![ASLAB Inventory Popup Edit](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-InventoryPage-PopupEditButton.png)
![ASLAB Inventory Popup Trash](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-InventoryPage-PopupTrashButton.png)
![ASLAB Returns](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-ReturnsPage.png)
![ASLAB Maintenance](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-MaintenancePage.png)
![ASLAB Maintenance Popup Restore](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-MaintenancePage-PopupRestoreButton.png)
![ASLAB Schedule](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-SchedulePage.png)
![ASLAB Audit Logs](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-AuditLogsPage.png)
![ASLAB Account Profile](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardASLAB-AccountProfilePage.png)

### Dashboard Dosen Pengampu

![Dashboard Dosen](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosenPage.png)
![Dosen Monitoring 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-MonitoringPage-1.png)
![Dosen Monitoring 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-MonitoringPage-2.png)
![Dosen Monitoring 3](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-MonitoringPage-3.png)
![Dosen Schedule](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-SchedulePage.png)
![Dosen Analytics](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-AnalyticsPage.png)
![Dosen Analytics Popup Print 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-AnalyticsPage-PopupPrintPDFButton-1.png)
![Dosen Analytics Popup Print 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-AnalyticsPage-PopupPrintPDFButton-2.png)
![Dosen Audit Logs](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-AuditLogsPage.png)
![Dosen Account Profile](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardDosen-AccountProfilePage.png)

### Dashboard Master Lab

![Dashboard Master Lab 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-1.png)
![Dashboard Master Lab 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-2.png)
![Master Lab Laboratory Data](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-LaboratoryDataPage.png)
![Master Lab Laboratory Data Popup Add](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-LaboratoryDataPage-PopupAddButton.png)
![Master Lab Laboratory Data Popup Edit](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-LaboratoryDataPage-PopupEditButton.png)
![Master Lab Laboratory Data Popup Trash](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-LaboratoryDataPage-PopupTrashButton.png)
![Master Lab ASLAB Management](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-ASLABManagementPage.png)
![Master Lab Approval](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-ApprovalPage.png)
![Master Lab Inventory](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-InventoryPage.png)
![Master Lab Inventory Popup Edit](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-InventoryPage-PopupEditButton.png)
![Master Lab Inventory Popup Trash](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-InventoryPage-PopupTrashButton.png)
![Master Lab Maintenance](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-MaintenancePage.png)
![Master Lab Maintenance Popup Restore](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-MaintenancePage-PopupRestoreButton.png)
![Master Lab Schedule](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-SchedulePage.png)
![Master Lab Audit Logs](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-AuditLogsPage.png)
![Master Lab Analytics Report](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-AnalyticsReportPage.png)
![Master Lab Account Profile](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardMasterLab-AccountProfilePage.png)

### Dashboard Admin Sistem

![Dashboard Admin](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardAdminPage.png)
![Admin User Management](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardAdmin-ManagementUsers.png)
![Admin User Management Popup Execution](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardAdmin-ManagementUsers-PopupExecutionButton.png)
![Admin User Management Popup Mutasi](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardAdmin-ManagementUsers-PopupMutasiButton.png)
![Admin History Log](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardAdmin-HistoryLogPage.png)
![Admin Notifications](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardAdmin-NotificationsPage.png)
![Admin Account Profile 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardAdmin-AccountProfilePage-1.png)
![Admin Account Profile 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/DashboardAdmin-AccountProfilePage-2.png)

### Alur Peminjaman Fasilitas Lab

![Alur Peminjaman 1](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%20Ruangan%201%20-%20Cek%20Ketersediaan.png)
![Alur Peminjaman 2](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%20Ruangan%202.png)
![Alur Peminjaman 3](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%20Ruangan%203%20-%20Cek%20Tanggal%20dan%20Waktu.png)
![Alur Peminjaman 4](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%20Ruangan%204%20-%20Isi%20Tanggal%20Waktu%20dan%20Tujuan%20terus%20Submit.png)
![Alur Peminjaman 5](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%20Ruangan%205%20-%20Status%20Pending.png)
![Alur Peminjaman 6](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%20Ruangan%206%20-%20Halaman%20Persetujuan%20ASLAB%20atau%20Master%20Lab.png)
![Alur Peminjaman 7](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%20Ruangan%206%20-%20Halaman%20Persetujuan%20Popup%20Approve%20oleh%20ASLAB%20atau%20Master%20Lab.png)
![Alur Peminjaman 8](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%20Ruangan%208%20-%20Di%20setujui%20oleh%20ASLAB%20atau%20Master%20Lab%20dan%20Status%20Berubah%20menjadi%20Disetujui.png)
![Alur Peminjaman 9](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%209%20-%20ASLAB%20Menyerahkan%20Ruangan.png)
![Alur Peminjaman 10](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%2010%20-%20Notifikasi%20Sukes%20untuk%20di%20serahkan.png)
![Alur Peminjaman 11](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%2011%20-%20Status%20berubah%20menjadi%20Dipinjam.png)
![Alur Peminjaman 12](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%2012%20-%20Klik%20Print%20PDF%20buat%20Struke%20Barang%20Bukti%20Peminjaman.png)
![Alur Peminjaman 13](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%2013%20-%20ASLAB%20mencatat%20kondisi%20ruangan%20untuk%20pengembaliannya.png)
![Alur Peminjaman 14](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%2014%20-%20Notifikasi%20Sukses%20atas%20tercatatnya%20kondisi%20tersebut.png)
![Alur Peminjaman 15](public/Dokumentasi%20Proyek%20SIMLAB-UNESA/Alur%20Peminjaman%2015%20-%20Status%20berubah%20menjadi%20Dikembalikan.png)

---

## Kontributor / Tim Pengembang

- **Ahmad Ramadhan Shobrunjamil (24051204168)** (Core Developer)
- **Muhammad Anwar Ismail (24051204161)** (Backend Engineer)
- **Adam Rahmatulloh (24051204162)** (Frontend Developer)
- **Muhammad Ilham Jazuli (24051204154)** (Database & Documentation)
- **Muhammad Farhan (25051204444)** (UI/UX Designer)

---

© 2026 Tim Pengembang SIM-LAB UNESA. All Rights Reserved.
