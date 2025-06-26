**Panduan Teknis Aplikasi Pinjaman Barang**

---

## 1. Hardware Requirement

Sebelum memulai instalasi, pastikan sistem Anda memenuhi prasyarat berikut:

- **OS**: Linux, macOS, atau Windows (dengan WSL2)
- **Web Server**: Apache/Nginx atau built-in PHP server
- **PHP**: versi 8.0 ke atas
- **Composer**: untuk dependency management
- **Database**: MySQL/MariaDB (≥ 5.7) atau PostgreSQL (opsional)
- **Git**: minimal versi 2.x

## 2. Instalasi Aplikasi si-peminjaman

1. **Clone repository**

   ```bash
   git clone git@github.com:nvshgg/si-peminjaman.git
   cd si-peminjaman
   ```

2. **Install dependencies**

   ```bash
   composer i
   ```

3. **Copy file environment**

   ```bash
   cp .env.example .env
   ```

4. **Generate application key**

   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**

   - Buka `.env` dan atur:
     ```ini
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=si-peminjaman
     DB_USERNAME=root
     DB_PASSWORD=secret
     ```

6. **Jalankan migrasi dan seeder**

   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan aplikasi**

   ```bash
   php artisan serve
   ```

   Akses ke: `http://localhost:8000`

## 3. Flowchart Alur Aplikasi
![flownchart](public/dist/ERD-peminjaman.png)

**Keterangan Tambahan:**

- Alur Peminjaman akan memvalidasi ketersediaan stok.
- Pengembalian hanya bisa dilakukan sebagian atau penuh sesuai peminjaman.

## 4. ERD (Entity-Relationship Diagram)


**Detail Relasi:**

- **ITEMS ke ITEM\_LOANS**: satu barang bisa dipinjam berkali-kali.
- **ITEM\_LOANS ke ITEM\_RETURNS**: satu peminjaman bisa memiliki beberapa pengembalian.
- **USERS ke ITEM\_LOANS**: satu user bisa melakukan banyak peminjaman.

---

Dokumentasi ini dapat dikembangkan dengan modul login multi-role (admin, petugas, peminjam), audit log, export data, dan filter laporan tanggal.

