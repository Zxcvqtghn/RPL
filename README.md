# MeSketch Studio - Premium Interior Design Portal

MeSketch adalah platform konsultasi desain interior modern yang dibangun dengan **Laravel 13** dan **Tailwind CSS v4**. Aplikasi ini mengedepankan estetika premium, alur kerja yang terukur, dan pengalaman pengguna yang seamless.

## ✨ Fitur Utama
- **Premium Landing Page**: Desain modern dengan *glassmorphism navigation*, tipografi *Outfit*, dan animasi yang halus.
- **Tailwind CSS v4 Integration**: Menggunakan versi terbaru Tailwind untuk styling yang lebih cepat, ringan, dan modern.
- **Dynamic Content**: Artikel edukatif dan testimoni klien yang dikelola langsung dari database.
- **Enhanced Writer Dashboard**: Dashboard khusus untuk kontributor konten dengan ringkasan artikel dan akses cepat untuk pembuatan konten.
- **Admin Management Panel**: Kendali penuh atas data master, termasuk pengelolaan tim staff, testimoni, dan tracking status booking secara real-time.
- **Client Area**: Portal khusus klien untuk memantau progress proyek dan histori booking secara transparan.

---

## 🚀 Panduan Instalasi (Windows - XAMPP/Laragon)

Ikuti langkah-langkah di bawah ini untuk menjalankan project di lingkungan lokal Anda.

### 1. Persiapan Database
1. Pastikan **MySQL/MariaDB** sudah aktif.
2. Buat database baru dengan nama **`mesketch`**.

### 2. Konfigurasi Environment
Salin `.env.example` menjadi `.env` dan sesuaikan kredensial database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mesketch
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Instalasi Dependency
Buka terminal di direktori project:
```bash
composer install
npm install
php artisan key:generate
```

### 4. Migrasi & Seeding Data
Gunakan perintah berikut untuk inisialisasi database dan mengisi data contoh:
```bash
php artisan migrate:fresh --seed
```

### 5. Menjalankan Aplikasi
Buka dua terminal terpisah:
- **Terminal 1 (Backend):**
  ```bash
  php artisan serve
  ```
- **Terminal 2 (Frontend/Assets):**
  ```bash
  npm run dev
  ```
Akses aplikasi di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔑 Akun Demo (Seed Data)
| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@mesketch.test` | `password123` |
| **Writer** | `writer@mesketch.test` | `password123` |
| **Client** | `client@mesketch.test` | `password123` |

---

## 🎨 Design System
- **Core CSS**: `public/css/mesketch.css` (Base System).
- **Utility CSS**: Tailwind CSS v4.
- **Colors**: Navy (#0f172a), Terracotta (Accent), Sage.
- **Typography**: 
  - `Outfit`: Digunakan untuk headings dan branding.
  - `Inter`: Digunakan untuk body text agar tetap terbaca dengan baik.

---
&copy; 2026 MeSketch Studio Development Team.
