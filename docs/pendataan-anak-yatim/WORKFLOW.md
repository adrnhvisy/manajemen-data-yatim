# Workflow - Alur Bisnis

## 1. Peran dan tanggung jawab

| Tahap | Pelaksana | Tanggung jawab | Hasil |
| --- | --- | --- | --- |
| Input | Kelurahan | Mengisi biodata, orang tua/wali, alamat, dan 11 dokumen | Draft atau diajukan ke kecamatan |
| Cek | Kecamatan | Memeriksa kelengkapan, kesesuaian administrasi, dan kewajaran data | Dikembalikan atau lolos kecamatan |
| Verifikasi | Kesra | Memverifikasi pengajuan yang sudah lolos kecamatan | Disetujui atau ditolak |

## 2. Alur normal

1. Kelurahan membuat `draft`.
2. Kelurahan melengkapi data anak, ayah, ibu, wali bila ada, dan dokumen.
3. Sistem menjalankan validasi server dan memastikan seluruh dokumen wajib tersedia.
4. Kelurahan mengirim; status menjadi `diajukan_ke_kecamatan`.
5. Kecamatan membuka dan memeriksa data serta dokumen.
6. Kecamatan meneruskan; status menjadi `lolos_kecamatan` lalu `diajukan_ke_kesra`.
7. Kesra memeriksa keseluruhan pengajuan.
8. Kesra memilih `disetujui` atau `ditolak_kesra` dan wajib mengisi catatan keputusan.

## 3. Alur perbaikan

Jika kecamatan menemukan kesalahan, pilih `kembalikan` dan isi catatan spesifik, misalnya field/dokumen yang harus diperbaiki. Status menjadi `dikembalikan_ke_kelurahan`. Kelurahan memperbaiki, mengganti dokumen bila perlu, lalu mengirim ulang ke kecamatan. Riwayat versi dan catatan lama tetap disimpan.

Kesra pada MVP berfungsi sebagai verifikator akhir. Jika Kesra menolak, status final menjadi `ditolak_kesra`; alasan penolakan dicatat. Mekanisme revisi setelah penolakan perlu diputuskan pada fase lanjutan agar tidak membingungkan status final.

## 4. Aturan transisi

| Dari | Aksi | Ke | Pelaksana |
| --- | --- | --- | --- |
| `draft` | kirim | `diajukan_ke_kecamatan` | Kelurahan |
| `dikembalikan_ke_kelurahan` | kirim ulang | `diajukan_ke_kecamatan` | Kelurahan |
| `diajukan_ke_kecamatan` | kembalikan | `dikembalikan_ke_kelurahan` | Kecamatan |
| `diajukan_ke_kecamatan` | teruskan | `diajukan_ke_kesra` | Kecamatan |
| `diajukan_ke_kesra` | setujui | `disetujui` | Kesra |
| `diajukan_ke_kesra` | tolak | `ditolak_kesra` | Kesra |

Catatan pada pengembalian dan penolakan wajib diisi. Setiap aksi menghasilkan `review`, `status_history`, dan `audit_log`.

## 5. Kondisi khusus

- Data tidak lengkap: tetap draft dan tampilkan daftar kekurangan.
- Dokumen kadaluarsa/tidak terbaca: kecamatan mengembalikan dengan alasan.
- Pengguna pindah unit: akses record mengikuti penugasan dan dicatat admin.
- Duplikasi NIK: sistem menandai dan menahan pengiriman untuk pemeriksaan berwenang.
- Keputusan ganda: service menolak aksi jika status sudah berubah.
