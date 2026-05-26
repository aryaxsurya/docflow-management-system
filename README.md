# 📋 DocFlow Management System

> Sistem manajemen alur dokumen berbasis web dengan review bertingkat — dibangun menggunakan **Laravel 12** dan **MySQL**.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## 📖 Tentang Proyek

**DocFlow Management System** adalah aplikasi web untuk mengelola proses pengajuan, review, dan pengesahan dokumen secara bertingkat di dalam sebuah organisasi. Sistem ini dirancang dengan metodologi *Iterative Software Development* berdasarkan buku *A Concise Introduction to Software Engineering* oleh Pankaj Jalote (Springer, 2008).

### Latar Belakang

Pengelolaan dokumen secara manual (via email atau fisik) sering menyebabkan keterlambatan, kehilangan dokumen, dan kurangnya transparansi status. DocFlow hadir sebagai solusi digital yang mengotomasi alur review, memberikan visibilitas penuh kepada semua pihak, dan mencatat setiap aktivitas melalui audit log.

---

## ✨ Fitur Utama

### 👤 Manajemen Pengguna (Multi-Role)
- **3 peran pengguna:** User, Reviewer, dan Admin
- Registrasi akun dengan approval dari Admin
- Manajemen profil dan unit kerja

### 📄 Manajemen Dokumen
- Buat, simpan sebagai draft, edit, dan hapus dokumen
- Upload lampiran file (PDF, Word, Excel, dll.)
- Submit dokumen untuk memulai alur review
- Lihat riwayat perubahan status dokumen

### 🔄 Alur Review Bertingkat
- Review multi-level (Level 1 → Level 2 → Admin Approval)
- Setiap reviewer hanya melihat dokumen di level-nya
- Aksi reviewer: **Approve**, **Reject**, atau **Minta Revisi**
- Sistem kembali ke User untuk revisi jika diperlukan

### 🔔 Notifikasi & Audit
- Notifikasi real-time untuk setiap perubahan status
- Audit log lengkap: setiap aksi tercatat beserta IP dan timestamp
- Riwayat review tersimpan di `review_logs`

### 📊 Dashboard per Peran
- **User:** Status dokumen, draft yang belum disubmit, riwayat pengajuan
- **Reviewer:** Antrian dokumen yang menunggu review, deadline monitor
- **Admin:** Monitoring semua dokumen, manajemen user, arsip final

### 🗄️ Arsip & Laporan
- Dokumen yang disetujui otomatis masuk ke arsip
- Filter dan pencarian dokumen berdasarkan status, jenis, dan periode

---

## 🗂️ Alur Dokumen (State Diagram)

```
Draft → Submitted → Under Review (Lvl 1) → Under Review (Lvl 2) → Admin Approval → Archived
                         ↓                        ↓                      ↓
                   Revision Requested       Revision Requested        Rejected
                         ↓
                    (kembali ke User)
```

---

## 🗃️ Database Schema

| Tabel                  | Deskripsi                                      |
|------------------------|------------------------------------------------|
| `users`                | Data pengguna (role, status, unit kerja)       |
| `documents`            | Dokumen utama + status + current_level         |
| `document_attachments` | File lampiran per dokumen                      |
| `review_logs`          | Riwayat aksi setiap reviewer per level         |
| `notifications`        | Notifikasi per user                            |
| `audit_logs`           | Log seluruh aktivitas sistem                   |

---

## 🛠️ Tech Stack

| Komponen       | Teknologi              |
|----------------|------------------------|
| Backend        | Laravel 12 (PHP 8.2+)  |
| Database       | MySQL 8.0              |
| Frontend       | Blade + Tailwind CSS   |
| Auth           | Laravel Breeze / Sanctum |
| Queue          | Laravel Queue + Supervisor |
| Scheduler      | Laravel Scheduler (Cron) |
| Testing        | PHPUnit + Laravel Dusk |

---

## ⚙️ Cara Instalasi (Local Development)

### Prasyarat
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0
- Git

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/aryaxsurya/docflow-management-system.git
cd docflow-management-system

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node.js
npm install && npm run build

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di file .env
# DB_DATABASE=docflow
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 7. Jalankan migrasi dan seeder
php artisan migrate
php artisan db:seed --class=AdminUserSeeder

# 8. Buat storage symlink
php artisan storage:link

# 9. Jalankan server development
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

### Akun Default (Seeder)
| Role     | Email                    | Password   |
|----------|--------------------------|------------|
| Admin    | admin@docflow.test       | password   |
| Reviewer | reviewer@docflow.test    | password   |
| User     | user@docflow.test        | password   |

---

## 🚀 Deployment (Production)

```bash
# Setelah clone ke server
composer install --optimize-autoloader --no-dev
npm install && npm run build
cp .env.example .env
php artisan key:generate

# Edit .env: APP_ENV=production, APP_DEBUG=false, DB credentials

php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force

# Optimasi cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Permission
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data .
```

---

## 🧪 Testing

```bash
# Jalankan semua test
php artisan test

# Jalankan test spesifik
php artisan test --filter DocumentWorkflowTest

# Coverage report
php artisan test --coverage
```

---

## 📁 Struktur Folder

```
docflow-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # AuthController, DocumentController, ReviewController, AdminController
│   │   └── Requests/          # Form Request validation
│   ├── Models/                # User, Document, ReviewLog, AuditLog, dll.
│   ├── Services/              # DocumentService, ReviewService (business logic)
│   ├── Policies/              # Authorization per role
│   └── Events/ & Listeners/   # Notifikasi & audit log (decoupled)
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/                 # Blade templates per role
├── routes/
│   └── web.php
└── tests/
    ├── Unit/
    └── Feature/
```

---

## 📋 Metodologi Pengembangan

Proyek ini mengikuti **8 fase Iterative Software Development** berdasarkan metodologi Jalote:

| Fase | Aktivitas                             | Durasi    |
|------|---------------------------------------|-----------|
| 1    | Requirement Analysis & SRS            | 3–5 hari  |
| 2    | Project Planning (estimasi & risiko)  | 2–3 hari  |
| 3    | Arsitektur & Database Design          | 3–4 hari  |
| 4    | Setup Environment & Scaffolding       | 1–2 hari  |
| 5    | Implementasi Core Modules             | 15–20 hari|
| 6    | Testing & Quality Assurance           | 5–7 hari  |
| 7    | Deployment & Go-Live                  | 2–3 hari  |
| 8    | Maintenance & Iterasi Lanjutan        | Berkelanjutan |

**Total estimasi: ~35–45 hari kerja**

---

## 🤝 Kontribusi

Proyek ini dikembangkan sebagai tugas akademik. Kontribusi dan saran sangat diterima melalui [Issues](https://github.com/aryaxsurya/docflow-management-system/issues).

---

## 📜 Lisensi

Proyek ini menggunakan lisensi [MIT](LICENSE).

---

## 👤 Author

**Arya Surya**  
GitHub: [@aryaxsurya](https://github.com/aryaxsurya)

---

> *Panduan ini disusun berdasarkan A Concise Introduction to Software Engineering — Pankaj Jalote (Springer, 2008)*
