# SIMAGANG - Sistem Informasi Magang BPS Kota Pekanbaru

<p align="center">
    <img src="public/assets/bps-logo.svg" alt="BPS Logo" width="200">
</p>

<p align="center">
    <strong>Sistem Informasi Manajemen Magang untuk Badan Pusat Statistik Kota Pekanbaru</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-11.x-red.svg" alt="Laravel Version">
    <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
    <img src="https://img.shields.io/badge/Livewire-3.x-pink.svg" alt="Livewire Version">
    <img src="https://img.shields.io/badge/TailwindCSS-3.x-cyan.svg" alt="Tailwind Version">
</p>

---

## 📋 Deskripsi

SIMAGANG adalah aplikasi web untuk mengelola proses pendaftaran dan pelaksanaan magang di Badan Pusat Statistik (BPS) Kota Pekanbaru. Sistem ini memungkinkan mahasiswa/siswa untuk mendaftar magang secara online dan admin BPS untuk mengelola pengajuan tersebut.

## ✨ Fitur Utama

### Untuk Pengguna (Mahasiswa/Siswa)

- 📝 Registrasi akun dengan upload KTM
- 📄 Pengajuan magang dengan upload dokumen (surat pengantar, proposal)
- 📊 Dashboard untuk melihat status pengajuan
- 📅 Sistem presensi/absensi harian
- 📖 Pengisian logbook magang
- 📜 Download sertifikat magang

### Untuk Admin BPS

- 📋 Dashboard statistik pengajuan
- ✅ Verifikasi dan approval pengajuan magang (2 tahap)
- 👥 Monitor presensi peserta magang
- ⭐ Penilaian magang (5 aspek)
- 🎓 Generate sertifikat magang

### Keamanan

- 🔒 Proteksi SQL Injection pada semua form input
- 🛡️ XSS Protection
- 🔐 Autentikasi dengan hash password

---

## 🛠️ Tech Stack

| Teknologi     | Versi |
| ------------- | ----- |
| PHP           | ^8.2  |
| Laravel       | ^11.9 |
| Livewire      | ^3.5  |
| Tailwind CSS  | ^3.4  |
| Flowbite      | ^2.3  |
| Vite          | ^5.0  |
| MySQL/MariaDB | 5.7+  |

### Dependencies Utama

- **barryvdh/laravel-dompdf** - Generate PDF sertifikat
- **intervention/image** - Manipulasi gambar
- **livewire/livewire** - Komponen frontend reaktif
- **taos** - Animasi scroll

---

## 📦 Instalasi

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL/MariaDB
- Laragon/XAMPP/WAMP (untuk Windows) atau environment PHP lainnya

### Langkah Instalasi

1. **Clone repository**

    ```bash
    git clone https://github.com/username/Sistem_Magang_BPS_Kota_Pekanbaru.git
    cd Sistem_Magang_BPS_Kota_Pekanbaru
    ```

2. **Install dependencies PHP**

    ```bash
    composer install
    ```

3. **Install dependencies Node.js**

    ```bash
    npm install
    ```

4. **Copy file environment**

    ```bash
    cp .env.example .env
    ```

5. **Generate application key**

    ```bash
    php artisan key:generate
    ```

6. **Konfigurasi database di file `.env`**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=simagang_bps
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. **Jalankan migrasi database**

    ```bash
    php artisan migrate
    ```

8. **Buat symbolic link untuk storage**

    ```bash
    php artisan storage:link
    ```

9. **Build assets frontend**

    ```bash
    npm run build
    ```

10. **Jalankan server development**

    ```bash
    php artisan serve
    ```

11. Buka browser dan akses `http://127.0.0.1:8000`

---

## 🔧 Konfigurasi Tambahan

### Email (untuk Reset Password)

Konfigurasi SMTP di file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email@gmail.com
MAIL_PASSWORD=app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@bps.go.id
MAIL_FROM_NAME="SIMAGANG BPS"
```

### Storage untuk Upload File

Pastikan folder `storage/app/public` memiliki permission yang tepat dan symbolic link sudah dibuat.

---

## 📁 Struktur Project

```
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controller untuk routing
│   │   └── Middleware/        # Middleware (auth, SQL injection protection)
│   ├── Livewire/              # Komponen Livewire
│   ├── Models/                # Model Eloquent
│   └── Rules/                 # Custom validation rules
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── public/
│   └── assets/                # Assets publik (gambar, CSS, JS)
├── resources/
│   ├── css/                   # Source CSS
│   ├── js/                    # Source JavaScript
│   └── views/                 # Blade templates
│       ├── admin/             # Views untuk admin
│       ├── layouts/           # Layout templates
│       ├── livewire/          # Livewire component views
│       ├── pdf/               # Template PDF (sertifikat)
│       └── usernormal/        # Views untuk user biasa
└── routes/
    └── web.php                # Definisi routes
```

---

## 👥 Akun Default

Setelah menjalankan seeder, akun admin/pegawai berikut akan tersedia:

### Admin/Pegawai

Untuk membuat akun default, jalankan seeder:

```bash
php artisan db:seed --class=PegawaiSeeder
```

| Nama   | Email                     | Password    | Role  |
| ------ | ------------------------- | ----------- | ----- |
| admin1 | admin@gmail.com           | jawejawe123 | Admin |
| admin2 | pembimbingipds1@gmail.com | jawejawe123 | Admin |
| admin3 | pembimbingipds2@gmail.com | jawejawe123 | Admin |

> **⚠️ Penting:** Segera ganti password default setelah login pertama kali!

Login admin melalui halaman `/login-pegawai`.

### User Biasa

Registrasi melalui halaman `/registrasi`.

---

## 🚀 Deployment

### Production Build

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Optimasi

```bash
composer install --optimize-autoloader --no-dev
php artisan optimize
```

---

## 📝 Alur Penggunaan

### Alur Pendaftaran Magang

1. **Buat Akun** - Daftar dengan email aktif dan upload KTM
2. **Isi Formulir** - Lengkapi data pendaftaran magang
3. **Upload Dokumen** - Unggah surat pengantar dan proposal
4. **Verifikasi** - Tunggu proses verifikasi admin (2 tahap)
5. **Mulai Magang** - Setelah diterima, mulai magang dan isi presensi harian

### Status Pengajuan

- `masa-daftar` - Belum mengajukan
- `pending` - Menunggu verifikasi tahap 1
- `accept-first` - Lolos tahap 1, menunggu tahap 2
- `reject-first` - Ditolak tahap 1
- `accept-final` - Diterima final, bisa mulai magang
- `reject-time` - Ditolak karena kuota penuh
- `selesai` - Magang selesai, sertifikat sudah terbit

---

## 🤝 Kontribusi

Kontribusi selalu diterima! Silakan buat pull request atau buka issue untuk diskusi.

---

## 📄 Lisensi

Project ini dibuat oleh Mohammad Ferry Irwansyah

---

## 📞 Kontak

- Email: ferryirwansyah394251@gmail.com

---

<p align="center">
    Made with ❤️ for BPS Kota Pekanbaru
</p>
