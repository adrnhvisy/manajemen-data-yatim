# PRD - Sistem Pendataan Anak Yatim

## 1. Ringkasan

Sistem ini adalah aplikasi web internal Pemerintah Kabupaten Pelalawan untuk mengelola pendataan, pemeriksaan, dan verifikasi calon penerima bantuan anak yatim. Cakupan wilayah awal: kelurahan/desa, kecamatan, dan Kesra.

Alur utama: **Kelurahan menginput -> Kecamatan memeriksa -> Kesra memverifikasi dan menyetujui/menolak**.

## 2. Masalah

Pendataan dan pemeriksaan berkas berisiko tersebar, sulit dilacak, dan tidak memiliki riwayat keputusan yang seragam. Sistem perlu menyediakan satu sumber data dengan status, komentar, dokumen, dan jejak audit yang jelas.

## 3. Tujuan

- Mengumpulkan data anak dan orang tua/wali secara terstruktur.
- Memastikan data diperiksa berjenjang sesuai kewenangan.
- Mengembalikan data yang salah ke kelurahan dengan alasan yang dapat ditindaklanjuti.
- Menyediakan keputusan Kesra yang terdokumentasi.
- Menjaga kerahasiaan NIK, rekening, dan dokumen keluarga.

## 4. Batasan MVP

Termasuk: autentikasi pengguna, pembatasan wilayah kerja, CRUD pengajuan oleh kelurahan, unggah 11 jenis dokumen, pemeriksaan kecamatan, verifikasi Kesra, komentar/revisi, status, riwayat, pencarian, dan laporan ringkas.

Belum termasuk: integrasi Dukcapil, integrasi bank, pencairan otomatis, tanda tangan elektronik, aplikasi mobile native, dan penilaian kelayakan otomatis.

## 5. Peran

- **Operator Kelurahan**: membuat, mengubah, melengkapi, dan mengirim pengajuan dari wilayahnya.
- **Petugas Kecamatan**: memeriksa kelengkapan dan kesesuaian data; meneruskan atau mengembalikan.
- **Petugas Kesra**: melakukan verifikasi akhir; menyetujui atau menolak.
- **Administrator**: mengelola pengguna, wilayah, master data, dan memantau audit; tidak menggantikan keputusan verifikator tanpa jejak audit.

## 6. Indikator keberhasilan

- Setiap pengajuan memiliki status dan pemilik proses yang jelas.
- Tidak ada pengajuan yang dapat melewati pemeriksaan kecamatan.
- Setiap pengembalian atau penolakan memiliki alasan wajib.
- Dokumen wajib dapat diperiksa per jenis dan versinya.
- Riwayat perubahan dan keputusan dapat ditelusuri.

## 7. Asumsi

- Satu akun terikat pada satu unit kerja dan wilayah kerja.
- NIK anak dan NIK orang tua disimpan sebagai teks, bukan angka.
- Kelurahan/desa pada MVP mengikuti nomenklatur wilayah yang disepakati pemerintah daerah.
- Data bantuan akan dipakai untuk verifikasi administrasi, bukan sebagai keputusan otomatis tentang kondisi sosial.
