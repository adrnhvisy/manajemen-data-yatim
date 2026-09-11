# User Stories

## Kelurahan

- Sebagai operator kelurahan, saya ingin membuat draft data anak agar dapat mengisi data bertahap.
- Sebagai operator kelurahan, saya ingin wilayah kelurahan terisi otomatis agar data tidak salah wilayah.
- Sebagai operator kelurahan, saya ingin melihat field wajib yang belum diisi agar pengajuan tidak tertahan.
- Sebagai operator kelurahan, saya ingin mengunggah dan mengganti dokumen berdasarkan jenisnya agar berkas mudah diperiksa.
- Sebagai operator kelurahan, saya ingin mengirim data ke kecamatan agar proses pemeriksaan dimulai.
- Sebagai operator kelurahan, saya ingin melihat alasan pengembalian agar dapat memperbaiki kesalahan.
- Sebagai operator kelurahan, saya ingin melihat riwayat pengajuan agar tahu siapa yang memproses dan kapan.

## Kecamatan

- Sebagai petugas kecamatan, saya ingin melihat antrean pengajuan dari kelurahan di wilayah saya agar dapat memeriksa sesuai kewenangan.
- Sebagai petugas kecamatan, saya ingin memeriksa biodata dan dokumen dalam satu halaman agar pemeriksaan efisien.
- Sebagai petugas kecamatan, saya ingin mengembalikan data dengan catatan perbaikan agar kelurahan tahu tindakan berikutnya.
- Sebagai petugas kecamatan, saya ingin meneruskan pengajuan yang sesuai ke Kesra agar alur berjenjang terjaga.
- Sebagai petugas kecamatan, saya ingin melihat keputusan dan catatan pemeriksaan sebelumnya agar tidak mengulang pekerjaan.

## Kesra

- Sebagai petugas Kesra, saya ingin melihat hanya pengajuan yang lolos kecamatan agar fokus pada verifikasi akhir.
- Sebagai petugas Kesra, saya ingin membandingkan data dengan dokumen agar dapat menilai kesesuaian.
- Sebagai petugas Kesra, saya ingin menyetujui pengajuan yang sesuai agar status penerima tercatat.
- Sebagai petugas Kesra, saya ingin menolak pengajuan dengan alasan wajib agar keputusan dapat dipertanggungjawabkan.

## Admin

- Sebagai admin, saya ingin mengelola akun dan unit kerja agar akses sesuai struktur organisasi.
- Sebagai admin, saya ingin mengelola master wilayah agar data otomatis mengikuti wilayah kerja.
- Sebagai admin, saya ingin melihat audit log agar perubahan sensitif dapat ditelusuri.

## Kriteria lintas cerita

Setiap aksi yang mengubah data atau status harus memiliki otorisasi, validasi server, hasil yang dapat dilihat pengguna, dan jejak audit. Data sensitif harus dimasking sesuai peran.
