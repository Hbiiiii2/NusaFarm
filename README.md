<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Laravel" />
</p>

# NusaFarm

Platform investasi pertanian yang menghubungkan investor dengan petani melalui proyek pertanian terverifikasi. Aplikasi ini fokus mobile-first dengan fitur wallet, portfolio investasi, marketplace lahan (Browse), gamifikasi (XP, level, badge), laporan harian petani, dan kolaborasi antar peran (manajer lapangan, logistik, penyedia pupuk, pedagang pasar, landlord, admin).

## Fitur Utama

- Investasi berbasis Farmland: jelajahi lahan siap investasi dengan filter dan sort dinamis
- Portfolio investor: ringkasan total investasi, potensi return, rata-rata ROI, serta riwayat investasi
- Detail investasi: media laporan harian terbaru dari petani (foto/video)
- Laporan harian Petani: unggah foto/video, cuaca, kondisi tanaman, dan hama
- Manajer Lapangan: review laporan harian secara rinci, approve/reject dengan catatan
- Wallet: top up, penarikan, riwayat transaksi
- Gamifikasi: missions, badges, XP, level, minigame “Siram Tanaman”
- Landing page modern dan mobile-first

## Tech Stack

- Laravel 10, PHP 8+
- Blade + Tailwind CSS + Font Awesome
- MySQL / MariaDB

## Persiapan Lingkungan

1. Salin env contoh
   ```bash
   cp .env.example .env
   ```
2. Atur kredensial DB di `.env`
3. Install dependencies
   ```bash
   composer install
   npm install
   ```
4. Generate app key
   ```bash
   php artisan key:generate
   ```
5. Migrasi dan seeding
   ```bash
   php artisan migrate --seed
   ```
6. Link storage (untuk akses foto/video laporan)
   ```bash
   php artisan storage:link
   ```
7. Jalankan server dev
   ```bash
   php artisan serve
   ```

Opsional (Vite/Tailwind dev):
```bash
npm run dev
```

## Akun Dummy (Seeder)

- Investor: `investor@nusafarm.com` / `password`
- Landlord: `landlord@nusafarm.com` / `password`
- Petani: `petani@nusafarm.com` / `password`
- Manajer Lapangan: `manajer@nusafarm.com` / `password`
- Logistik: `logistik@nusafarm.com` / `password`
- Penyedia Pupuk: `pupuk@nusafarm.com` / `password`
- Pedagang Pasar: `pedagang@nusafarm.com` / `password`
- Admin: `admin@nusafarm.com` / `password`

Seeder menyiapkan:
- Farmland status `ready_for_investment` dengan periode dan nominal investasi
- Projects aktif per farmland
- Penugasan `FarmingTask` untuk Petani pada proyek
- DailyReport contoh (tanpa media) agar halaman investasi menampilkan update
- Investments dan WalletTransactions untuk Investor
- Notifications contoh

## Alur Utama

- Landing page: `GET /`
- Auth: `GET /login`, `GET /register`
- Dashboard: `GET /dashboard` (mobile-first)
- Browse Farmlands: `GET /projects` (filter kategori, min/max invest, size, sort)
- Investment flow: `GET /projects/{farmland}` → `GET /investments/create/{farmland}` → `POST /investments/{farmland}`
- Portfolio investor: `GET /investments/portfolio`
- Detail investasi: `GET /investments/show/{investment}` (menampilkan media laporan terbaru)
- Petani laporan: `GET /petani/daily-reports/create` → `POST /petani/daily-reports`
- Manajer review laporan: `GET /manajer/reports` → `GET /manajer/reports/{report}` → approve/reject

## Konvensi & Kode

- Mobile-first UI (Tailwind). Komponen utama telah dioptimasi untuk layar kecil (kartu ringkas, grid adaptif, truncate teks).
- Relasi investasi berbasis `farmland_id` (bukan `project_id`).
- DailyReport terhubung ke `project`, dan ditautkan ke lahan melalui `project.farmland` untuk menampilkan media di detail investasi.

## Lisensi

MIT License.
