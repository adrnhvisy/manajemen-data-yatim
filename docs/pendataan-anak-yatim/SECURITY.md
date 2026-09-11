# Security - Batas Keamanan

## 1. Data yang dilindungi

NIK anak/orang tua/wali, nomor KK, nomor rekening, alamat, tanggal lahir, kondisi keluarga, foto, dan semua dokumen adalah data sensitif. Akses mengikuti prinsip least privilege dan kebutuhan tugas.

## 2. Kontrol akses

- Akun wajib login untuk seluruh modul bisnis.
- Role dan unit kerja diperiksa server-side melalui middleware dan Policy.
- Kelurahan hanya dapat mengakses data yang dibuat/ditugaskan ke kelurahannya.
- Kecamatan hanya dapat mengakses kelurahan di bawah kecamatannya.
- Kesra dapat mengakses data yang sudah lolos kecamatan sesuai cakupan kewenangan.
- Admin tidak otomatis boleh melihat seluruh dokumen tanpa kebutuhan dan audit.
- Endpoint dokumen tidak boleh berupa URL publik yang dapat ditebak.

## 3. Perlindungan data

- Gunakan enkripsi application-level untuk NIK, nomor KK, dan rekening jika kebutuhan operasional memungkinkan.
- Simpan hash terpisah untuk pencarian duplikasi.
- Masking pada daftar dan export, misalnya hanya menampilkan sebagian NIK.
- Jangan menulis data sensitif ke log, exception detail, analytics, atau notifikasi.
- Gunakan storage private dan download melalui controller berizin.
- Tetapkan retensi, pemusnahan, dan backup bersama pemilik kebijakan pemerintah daerah.

## 4. Keamanan upload

- Validasi MIME nyata, ekstensi yang diizinkan, ukuran, checksum, dan nama file.
- Simpan nama acak di luar web root.
- Tolak file executable, arsip tidak perlu, path traversal, dan konten yang tidak sesuai.
- Pertimbangkan antivirus scanning sebelum dokumen tersedia untuk reviewer.
- Preview file hanya dengan response yang aman dan content disposition yang tepat.

## 5. Keamanan aplikasi

- Gunakan CSRF protection, escaping output Blade, rate limiting login, dan session timeout.
- Password menggunakan hashing Laravel; jangan menyimpan password mentah.
- Terapkan HTTPS di deployment.
- Gunakan query builder/Eloquent parameterized; jangan merangkai SQL dari input.
- Validasi status dengan state transition service untuk mencegah bypass melalui request manual.
- Audit login penting, akses dokumen, perubahan data, pengembalian, persetujuan, dan penolakan.

## 6. Respons insiden

Sediakan prosedur untuk menonaktifkan akun, mencabut akses dokumen, mengamankan log, mengidentifikasi data terdampak, dan melaporkan insiden kepada penanggung jawab. Retensi log dan akses audit harus dibatasi.

## 7. Risiko yang belum diputuskan

Pemilik sistem perlu menetapkan dasar hukum pemrosesan data, masa simpan, siapa yang boleh export, apakah data perlu dienkripsi di database, serta standar klasifikasi dokumen sebelum produksi.
