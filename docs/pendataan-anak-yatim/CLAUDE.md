# Instruksi Claude Code

## Konteks proyek

Ini adalah aplikasi Laravel untuk pendataan anak yatim Pemerintah Kabupaten Pelalawan. Alur kewenangan wajib: `kelurahan -> kecamatan -> kesra`.

## Aturan kerja

- Baca `PRD.md`, `REQUIREMENTS.md`, `DATABASE.md`, `ARCHITECTURE.md`, `SECURITY.md`, dan `WORKFLOW.md` sebelum mengubah fitur terkait.
- Pertahankan pemisahan kewenangan. Kelurahan input, kecamatan memeriksa, Kesra memverifikasi akhir.
- Jangan membuat transisi status baru tanpa memperbarui `WORKFLOW.md`, test, dan audit.
- Validasi server adalah sumber kebenaran. Jangan mempercayai role, wilayah, status, atau ID dari client.
- Data NIK, KK, rekening, alamat, dan dokumen adalah sensitif. Ikuti `SECURITY.md`.
- Gunakan Policy untuk akses, Form Request untuk validasi, service untuk workflow, dan transaksi untuk keputusan.
- Jangan menampilkan NIK/rekening penuh pada daftar atau log.
- Setiap perubahan status harus punya aktor, waktu, catatan bila diwajibkan, dan riwayat.
- Tambahkan test untuk jalur normal, pengembalian, batas wilayah, dokumen wajib, dan akses lintas role.
- Hindari mengubah file di luar scope tugas; jangan menghapus perubahan pengguna.

## Perintah verifikasi

```bash
php artisan test
vendor/bin/pint --test
npm run build
```

Gunakan perintah yang tersedia di repository dan laporkan jika dependency atau environment belum siap.
