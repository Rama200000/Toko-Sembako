# Toko Sembako

Aplikasi kasir + toko online sederhana berbasis Laravel.

## Fitur Utama

- Panel Admin (login session-based)
- Manajemen Produk (tambah, edit, hapus)
- Upload foto produk (JPG/PNG/WEBP)
- Input transaksi penjualan
- Halaman Shop pembeli (home, kategori, keranjang, pesanan)
- Checkout cepat ke WhatsApp
- UI animasi halus (floating + reveal)

## Teknologi

- PHP 8.3+
- Laravel 13
- MySQL
- Tailwind CSS (via CDN pada blade)

## Setup Lokal

1. Clone repo

```bash
git clone https://github.com/Rama200000/Toko-Sembako.git
cd Toko-Sembako
```

2. Install dependency

```bash
composer install
npm install
```

3. Buat env dan app key

```bash
cp .env.example .env
php artisan key:generate
```

4. Atur database di `.env`, lalu migrate

```bash
php artisan migrate
```

5. Seed data awal produk

```bash
php artisan db:seed
```

6. Link storage agar foto produk tampil

```bash
php artisan storage:link
```

7. Jalankan aplikasi

```bash
php artisan serve
```

## Login Admin

Credential admin diset via `.env`:

```env
ADMIN_USERNAME=admin
ADMIN_PASSWORD=admin12345
```

## Alur Git yang Disarankan

- `main`: branch stabil/deploy
- `develop`: branch kerja harian
- branch fitur: `feat/nama-fitur`

Contoh:

```bash
git checkout develop
git checkout -b feat/upload-banner
```

## Catatan

- Folder `vendor`, `node_modules`, `.env`, dan build output sudah di-ignore.
- Seeder sekarang berisi data produk awal realistis, bukan user dummy.
