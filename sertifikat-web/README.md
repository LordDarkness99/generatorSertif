# Generator Sertifikat Selara Realti

Aplikasi Laravel untuk mengisi sertifikat berdasarkan template PDF. Formulir menampilkan pratinjau langsung dan menghasilkan file PDF A4 landscape yang dapat diunduh.

## Menjalankan aplikasi

Persyaratan: PHP 8.3 atau lebih baru, Composer, serta ekstensi PHP GD dan iconv.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Jalankan perintah dari folder proyek hasil clone. Jalankan `cp .env.example .env` hanya jika file `.env` belum tersedia.
Buka alamat yang ditampilkan oleh Artisan, biasanya `http://127.0.0.1:8000`.

## File sertifikat

- Template PDF: `storage/app/certificates/template.pdf`
- Tanda tangan untuk pratinjau: `public/images/signature.png`
- Tanda tangan untuk PDF: `storage/app/certificates/ttd-print.png`
- Font nama penerima: `resources/fonts/GreatVibes-Regular.ttf` (lisensi SIL Open Font License)

Generator mengisi nama penerima, tanggal, tanda tangan, dan nama penanda tangan. Jika template atau tanda tangan diganti, sesuaikan juga aset pratinjau dan tanda tangan cetak agar tampilannya tetap sama.

## Pengujian

```bash
php artisan test --compact tests/Feature/CertificateGenerationTest.php
```
