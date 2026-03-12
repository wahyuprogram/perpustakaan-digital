# 📚 Perpustakaan Digital

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)

Aplikasi Manajemen Perpustakaan Digital berbasis web yang dirancang untuk mempermudah proses pendataan buku, transaksi peminjaman, hingga pelaporan otomatis. Dibangun menggunakan **Laravel 10/11** dengan pendekatan desain **Earth Tone (Sage Green & Wood)** yang minimalis dan elegan.

---

## ✨ Fitur Unggulan

* **👥 Sistem Multi-Role:**
    * **Administrator:** Kontrol penuh sistem & manajemen akun (Admin, Petugas, Peminjam).
    * **Petugas:** Kelola buku, kategori, konfirmasi peminjaman, dan generate laporan.
    * **Peminjam (User):** Eksplorasi katalog, manajemen koleksi pribadi, ulasan, dan pantau denda.
* **📦 Manajemen Stok Otomatis:** Integrasi stok yang berkurang saat buku dipinjam dan bertambah otomatis saat dikembalikan.
* **💰 Kalkulator Denda Real-Time:** Perhitungan denda otomatis (Rp 1.000/hari) berdasarkan selisih tanggal jatuh tempo.
* **🗓️ Konfirmasi Pengembalian Fleksibel:** Fitur modal pop-up bagi petugas untuk mengatur tanggal pengembalian fisik dengan perhitungan denda instan (JavaScript).
* **📊 Laporan Canggih:** Filter laporan berdasarkan *Date Range* (Rentang Tanggal) lengkap dengan rekapan total denda dan transaksi.
* **💬 Interaksi Ulasan:** Sistem rating dan ulasan interaktif dengan fitur balasan dari petugas.
* **🔒 Keamanan Sesi:** Implementasi pencegahan *back button* browser setelah logout melalui pembersihan header cache.

---

## 🛠️ Tech Stack

* **Backend:** PHP & Laravel Framework
* **Database:** MySQL
* **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
* **Library:**
    * [Carbon](https://carbon.nesbot.com/) (Date & Time manipulation)
    * [Blade](https://laravel.com/docs/blade) (Templating Engine)
    * [Google Fonts](https://fonts.google.com/specimen/Poppins) (Poppins)

---

## 📸 Tampilan Aplikasi

| Dashboard Admin | Katalog Buku |
| :--- | :--- |
| ![Dashboard](<img width="600" height="300" alt="image" src="https://github.com/user-attachments/assets/20a1a5d7-8a47-46bf-987e-a16d66d9a8bf" />
) | ![Katalog](<img width="600" height="300" alt="image" src="https://github.com/user-attachments/assets/7bc8c4c9-49d6-477a-9a0c-130f0a3a4479" />
) |

| Detail Konfirmasi & Denda | Generate Laporan |
| :--- | :--- |
| ![Modal Denda](<img width="600" height="300" alt="image" src="https://github.com/user-attachments/assets/4d484bed-ed42-45d2-bea7-445885c5faef" />
) | ![Laporan](<img width="600" height="300" alt="image" src="https://github.com/user-attachments/assets/ded29cd9-0d5f-4906-b249-0a128a641726" />
) |

---

## 🚀 Cara Instalasi

1.  **Clone Repository:**
    ```bash
    git clone [https://github.com/wahyuprogram/perpustakaan-digital.git](https://github.com/wahyuprogram/perpustakaan-digital.git)
    cd perpustakaan-digital
    ```

2.  **Instalasi Dependency:**
    ```bash
    composer install
    npm install && npm run dev
    ```

3.  **Konfigurasi Environment:**
    Salin file `.env.example` menjadi `.env` dan atur koneksi database (DB_DATABASE).
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Migrasi & Seed Database:**
    ```bash
    php artisan migrate
    ```

5.  **Jalankan Server:**
    ```bash
    php artisan serve
    ```

---

## 🔑 Akun Uji Coba (Default)

| Role | Username | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin` | `password` |
| **Petugas** | `petugas` | `password` |
| **User** | `user` | `password` |

---

## 📝 Catatan Proyek
Proyek ini dikembangkan dengan fokus pada akurasi data dan *user experience*. Fitur denda dan manajemen stok telah melalui pengujian skenario *logic testing* untuk memastikan tidak ada nilai negatif atau ketidakkonsistenan data.

Dibuat dengan ❤️ oleh [Wahyu](https://github.com/wahyuprogram).
