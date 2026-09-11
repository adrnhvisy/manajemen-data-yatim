# Aturan Agent

## Prioritas

1. Ikuti permintaan pengguna.
2. Ikuti kontrak pada `PRD.md`, `REQUIREMENTS.md`, dan `WORKFLOW.md`.
3. Ikuti batas data pada `SECURITY.md`.
4. Pertahankan pola Laravel yang sudah dipakai repository.

## Sebelum mengubah kode

- Identifikasi modul dan role yang terdampak.
- Baca dokumen terkait di folder ini.
- Cari implementasi/test terdekat sebelum membuat abstraksi baru.
- Nyatakan asumsi yang belum diputuskan.

## Saat mengubah kode

- Buat perubahan kecil dan dapat diuji.
- Gunakan Form Request, Policy, service, dan transaksi sesuai `ARCHITECTURE.md`.
- Jangan bypass workflow lewat controller atau endpoint alternatif.
- Jangan menyimpan file sensitif di `public`.
- Jangan mencatat nilai NIK, rekening, atau isi dokumen ke log.
- Tambahkan atau sesuaikan test setiap kali aturan bisnis berubah.

## Setelah mengubah kode

- Jalankan test paling dekat terlebih dahulu, lalu verifikasi lint/build bila relevan.
- Periksa status, otorisasi, masking, dan audit.
- Perbarui dokumentasi bila keputusan bisnis atau schema berubah.
- Jangan membuat commit atau branch kecuali diminta.

## Pertanyaan yang harus dicatat

Jika kebutuhan belum jelas, catat sebagai keputusan terbuka di `ROADMAP.md`, bukan menebak perilaku produksi.
