# 🚗 LeaDrive - Pemilik Kursus

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)

**Aplikasi Manajemen Kursus Mengemudi untuk Pemilik Kursus**


## 👤 Penulis

**Gerardo Mayella Ardianta**
-   **NIM**: 235314003

---

## 📖 Deskripsi

**LeaDrive (Pemilik Kursus)** adalah platform berbasis web yang dirancang khusus untuk pemilik kursus mengemudi. Aplikasi ini memungkinkan pemilik untuk mengelola profil kursus, verifikasi data, memantau pesanan masuk, serta mengelola lokasi kursus menggunakan integrasi peta.

Dibangun dengan teknologi modern **Laravel 12** dan **Tailwind CSS 4**, aplikasi ini menawarkan performa responsif dan antarmuka yang elegan.

---

## ✨ Fitur Utama

-   **🔐 Otentikasi Aman**: Sistem login dan registrasi yang aman untuk pemilik kursus.
-   **🗺️ Integrasi Google Maps**: Penentuan lokasi kursus yang akurat saat pendaftaran dan verifikasi.
-   **📧 Notifikasi Email Otomatis**: Integrasi dengan **Mailtrap** untuk verifikasi akun, reset password, dan notifikasi status kursus (Diterima/Ditolak).
-   **📋 Manajemen Pesanan**: Antarmuka untuk melihat dan mengelola pesanan masuk dari calon siswa.
-   **✅ Verifikasi Kursus**: Alur verifikasi data kursus yang sistematis.
-   **📱 Desain Responsif**: Tampilan optimal di desktop maupun perangkat mobile.

---

## 🛠️ Teknologi yang Digunakan

-   **Backend**: Laravel 12 (PHP ^8.2)
-   **Frontend**: Blade Templates, Tailwind CSS v4.0
-   **Build Tool**: Vite
-   **Database**: PostgreSQL (supabase cloud)
-   **Layanan Pihak Ketiga**:
    -   Google Maps Platform (Maps JavaScript API)
    -   Mailtrap (Email Sandbox)

---

## ⚙️ Prasyarat Sistem

Sebelum memulai, pastikan sistem Anda telah terinstal:

-   PHP >= 8.2
-   Composer
-   Node.js & npm
-   PostgreSQL

---

## 🚀 Instalasi & Skenario Penggunaan

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/gerardomayella/LeaDrive-Pemilik-Kursus.git
    cd LeaDrive-Pemilik-Kursus
    ```

2.  **Masuk ke Direktori Aplikasi**
    Aplikasi utama berada di dalam folder `Application`.
    ```bash
    cd Application
    ```

3.  **Instalasi Dependencies**
    Install paket PHP dan Node.js yang dibutuhkan.
    ```bash
    composer install
    npm install
    ```

4.  **Konfigurasi Environment**
    Salin file `.env.example` ke `.env` dan sesuaikan konfigurasinya.
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan atur konfigurasi berikut:
    -   **Database**: Sesuaikan `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
    -   **Mailtrap**: Isi kredensial SMTP Mailtrap Anda.
    -   **Google Maps**: Tambahkan API Key Anda pada variabel environment yang sesuai.

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database**
    ```bash
    php artisan migrate
    ```

7.  **Jalankan Aplikasi**
    Anda perlu menjalankan server Laravel dan Vite secara bersamaan (atau gunakan terminal terpisah).
    ```bash
    # Terminal 1: Menjalankan Server Laravel
    php artisan serve

    # Terminal 2: Menjalankan Vite (untuk aset frontend)
    npm run dev
    ```

Akses aplikasi melalui browser di `http://127.0.0.1:8000`.

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
