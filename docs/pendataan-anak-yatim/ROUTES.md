# Struktur Route Aplikasi

## 1. Aturan penamaan

- Semua route bisnis berada di `routes/web.php` dan memakai middleware `web` bawaan Laravel.
- Semua route internal wajib memakai `auth`.
- Setiap kelompok role memakai middleware `role:<role>` dan prefix URI serta nama route yang sama.
- URI menggunakan kata benda; aksi proses memakai kata kerja yang jelas.
- Gunakan route model binding untuk `{childRecord}` setelah Policy memeriksa wilayah.
- Route tambahan yang spesifik harus didefinisikan sebelum `Route::resource` agar tidak tertangkap route parameter.
- Beri satu baris kosong antar kelompok role agar file mudah dipindai.

## 2. Peta kelompok route

| Kelompok | Middleware | Prefix URI | Prefix nama | Controller utama |
| --- | --- | --- | --- | --- |
| Umum terautentikasi | `auth` | `/` | `app.` | Dashboard redirect dan profil |
| Kelurahan | `auth`, `role:kelurahan` | `/kelurahan` | `kelurahan.` | `Kelurahan\*Controller` |
| Kecamatan | `auth`, `role:kecamatan` | `/kecamatan` | `kecamatan.` | `Kecamatan\*Controller` |
| Kesra | `auth`, `role:kesra` | `/kesra` | `kesra.` | `Kesra\*Controller` |

`role` adalah middleware alias yang didaftarkan aplikasi. Middleware hanya lapisan pertama; Policy dan Service tetap memverifikasi wilayah serta status record.

## 3. Susunan `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)
        ->name('app.dashboard');
});


Route::middleware(['auth', 'role:kelurahan'])
    ->prefix('kelurahan')
    ->name('kelurahan.')
    ->group(function () {
        Route::get('/dashboard', KelurahanDashboardController::class)
            ->name('dashboard');

        Route::resource('anak', KelurahanChildRecordController::class)
            ->except(['show']);

        Route::get('/anak/{childRecord}', [KelurahanChildRecordController::class, 'show'])
            ->name('anak.show');

        Route::post('/anak/{childRecord}/kirim', [KelurahanChildRecordController::class, 'submit'])
            ->name('anak.submit');

        Route::get('/laporan', [KelurahanReportController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/cetak', [KelurahanReportController::class, 'print'])
            ->name('laporan.print');
    });


Route::middleware(['auth', 'role:kecamatan'])
    ->prefix('kecamatan')
    ->name('kecamatan.')
    ->group(function () {
        Route::get('/dashboard', KecamatanDashboardController::class)
            ->name('dashboard');

        Route::get('/anak', [KecamatanReviewController::class, 'index'])
            ->name('anak.index');

        Route::get('/anak/{childRecord}', [KecamatanReviewController::class, 'show'])
            ->name('anak.show');

        Route::post('/anak/{childRecord}/kembalikan', [KecamatanReviewController::class, 'return'])
            ->name('anak.return');

        Route::post('/anak/{childRecord}/loloskan', [KecamatanReviewController::class, 'forward'])
            ->name('anak.forward');

        Route::get('/laporan', [KecamatanReportController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/cetak', [KecamatanReportController::class, 'print'])
            ->name('laporan.print');
    });


Route::middleware(['auth', 'role:kesra'])
    ->prefix('kesra')
    ->name('kesra.')
    ->group(function () {
        Route::get('/dashboard', KesraDashboardController::class)
            ->name('dashboard');

        Route::get('/anak', [KesraVerificationController::class, 'index'])
            ->name('anak.index');

        Route::get('/anak/{childRecord}', [KesraVerificationController::class, 'show'])
            ->name('anak.show');

        Route::post('/anak/{childRecord}/setujui', [KesraVerificationController::class, 'approve'])
            ->name('anak.approve');

        Route::post('/anak/{childRecord}/tolak', [KesraVerificationController::class, 'reject'])
            ->name('anak.reject');

        Route::get('/laporan', [KesraReportController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/cetak', [KesraReportController::class, 'print'])
            ->name('laporan.print');
    });
```

Contoh di atas adalah rancangan route; import controller final ditambahkan saat implementasi. Spasi kosong antar kelompok dipertahankan agar batas kewenangan mudah terlihat saat review.

## 4. Daftar route Kelurahan

| Method | URI | Name | Fungsi |
| --- | --- | --- | --- |
| GET | `/kelurahan/dashboard` | `kelurahan.dashboard` | Dashboard operator |
| GET | `/kelurahan/anak` | `kelurahan.anak.index` | Daftar data anak |
| GET | `/kelurahan/anak/create` | `kelurahan.anak.create` | Form data baru |
| POST | `/kelurahan/anak` | `kelurahan.anak.store` | Simpan draft |
| GET | `/kelurahan/anak/{childRecord}` | `kelurahan.anak.show` | Detail data |
| GET | `/kelurahan/anak/{childRecord}/edit` | `kelurahan.anak.edit` | Form edit |
| PUT/PATCH | `/kelurahan/anak/{childRecord}` | `kelurahan.anak.update` | Ubah draft/perbaikan |
| DELETE | `/kelurahan/anak/{childRecord}` | `kelurahan.anak.destroy` | Hapus draft |
| POST | `/kelurahan/anak/{childRecord}/kirim` | `kelurahan.anak.submit` | Kirim ke Kecamatan |
| GET | `/kelurahan/laporan` | `kelurahan.laporan.index` | Preview laporan |
| GET | `/kelurahan/laporan/cetak` | `kelurahan.laporan.print` | Cetak laporan |

## 5. Daftar route Kecamatan

| Method | URI | Name | Fungsi |
| --- | --- | --- | --- |
| GET | `/kecamatan/dashboard` | `kecamatan.dashboard` | Dashboard pemeriksa |
| GET | `/kecamatan/anak` | `kecamatan.anak.index` | Antrian pemeriksaan |
| GET | `/kecamatan/anak/{childRecord}` | `kecamatan.anak.show` | Detail dan checklist |
| POST | `/kecamatan/anak/{childRecord}/kembalikan` | `kecamatan.anak.return` | Kembalikan dengan catatan |
| POST | `/kecamatan/anak/{childRecord}/loloskan` | `kecamatan.anak.forward` | Teruskan ke Kesra |
| GET | `/kecamatan/laporan` | `kecamatan.laporan.index` | Preview rekap per kelurahan |
| GET | `/kecamatan/laporan/cetak` | `kecamatan.laporan.print` | Cetak rekap kecamatan |

## 6. Daftar route Kesra

| Method | URI | Name | Fungsi |
| --- | --- | --- | --- |
| GET | `/kesra/dashboard` | `kesra.dashboard` | Dashboard verifikator |
| GET | `/kesra/anak` | `kesra.anak.index` | Antrian data lolos Kecamatan |
| GET | `/kesra/anak/{childRecord}` | `kesra.anak.show` | Detail verifikasi akhir |
| POST | `/kesra/anak/{childRecord}/setujui` | `kesra.anak.approve` | Setujui |
| POST | `/kesra/anak/{childRecord}/tolak` | `kesra.anak.reject` | Tolak dengan alasan |
| GET | `/kesra/laporan` | `kesra.laporan.index` | Preview laporan lintas wilayah |
| GET | `/kesra/laporan/cetak` | `kesra.laporan.print` | Cetak per kelurahan/kecamatan |

## 7. Checklist route

- Route `GET` spesifik seperti `/laporan/cetak` diletakkan sebelum route parameter yang mungkin menangkapnya.
- Semua form `POST`, `PUT`, `PATCH`, dan `DELETE` menggunakan CSRF.
- Semua route detail memakai Policy record dan pembatasan wilayah.
- Route laporan dan cetak memakai `ReportPolicy`, bukan hanya middleware role.
- Request aksi status memakai Form Request terpisah.
- Jalankan `php artisan route:list -vv` saat implementasi untuk memeriksa URI, nama, controller, dan middleware yang terdaftar.
- Setelah route berubah pada deployment, jalankan cache route sesuai prosedur deployment.
