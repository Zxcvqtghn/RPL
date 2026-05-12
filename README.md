# MeSketch Studio - Premium Interior Design Portal

MeSketch adalah platform konsultasi desain interior modern yang dibangun dengan Laravel 13. Aplikasi ini mengedepankan estetika premium, alur kerja yang terukur, dan pengalaman pengguna yang seamless.

## ✨ Fitur Utama
- **Premium Landing Page**: Desain modern dengan *glassmorphism navigation*, tipografi *Outfit*, dan animasi yang halus.
- **Dynamic Content**: Artikel edukatif dan testimoni klien yang dikelola langsung dari database.
- **Client Dashboard**: Area khusus klien untuk memantau progress proyek dan histori booking (Role: `user`).
- **Management Panel**: CRUD artikel, testimoni, staff, dan pengelolaan status booking (Role: `admin`, `writer`).
- **Robust Tech Stack**: Laravel 13, MySQL/MariaDB, dan Vanilla CSS Design System.

---

## 🚀 Panduan Instalasi (Windows - XAMPP/Laragon)

Ikuti langkah-langkah di bawah ini untuk menjalankan project di lingkungan Windows.

### 1. Persiapan Database
1. Buka **XAMPP Control Panel** dan aktifkan **MySQL**.
2. Klik tombol **Admin** pada baris MySQL atau buka `http://localhost/phpmyadmin`.
3. Buat database baru dengan nama **`mesketch`**.
4. (Opsional) Jika teman-teman kamu menggunakan user `root` tanpa password (default XAMPP), lewati langkah ini.

### 2. Konfigurasi Environment
Buka file `.env` di folder project dan sesuaikan bagian database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mesketch
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Instalasi Dependency
Buka **Terminal** atau **CMD** di folder project:
```bash
composer install
php artisan key:generate
```

### 4. Migrasi & Seeding Data
Jalankan perintah ini untuk membuat tabel dan mengisi data contoh (artikel & testimoni):
```bash
php artisan migrate:fresh --seed
```

### 5. Menjalankan Server
Nyalakan server pengembangan Laravel:
```bash
php artisan serve
```
Akses aplikasi di: [http://127.0.0.1:8000](http://127.0.0.1:8000)
Akses aplikasi di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔑 Akun Demo (Seed Data)
- **Admin**: `admin@mesketch.test` / `password123`
- **Writer**: `writer@mesketch.test` / `password123`
- **Client**: `client@mesketch.test` / `password123`

---

## 🎨 Design System
Aplikasi ini menggunakan sistem desain kustom yang didefinisikan di `public/css/mesketch.css`.
- **Warna Utama**: Earthy Tones (Terracotta, Navy, Sage).
- **Tipografi**: Outfit (Headings), Inter (Body).
- **Shadows**: Soft, layered HSL shadows untuk efek premium.

---
&copy; 2026 MeSketch Studio Development Team.
