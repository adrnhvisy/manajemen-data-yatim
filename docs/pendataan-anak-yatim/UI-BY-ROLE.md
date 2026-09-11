# Rancangan Tampilan Berdasarkan Peran

## 1. Aturan umum tampilan

Semua halaman memakai layout yang sama: header berisi nama aplikasi dan akun aktif, navigasi sesuai peran, area konten utama, serta notifikasi status. Tampilan harus responsif untuk desktop kantor dan tablet.

Daftar data memakai tabel dengan kolom yang dapat dipindai, filter di bagian atas, pagination, dan keadaan loading/kosong/error. NIK dan nomor rekening selalu dimasking. Tombol final seperti meneruskan, menyetujui, menolak, dan mencetak meminta konfirmasi bila tindakan tersebut menghasilkan keputusan atau dokumen resmi.

## 2. Operator Kelurahan

### Dashboard Kelurahan

Komponen utama:

- Kartu ringkasan: total data, draft, menunggu pemeriksaan kecamatan, dikembalikan, disetujui, dan ditolak.
- Daftar pekerjaan terakhir dengan nama anak, nomor pengajuan, umur, status, dan tindakan.
- Peringatan data yang dikembalikan beserta alasan perbaikan.
- Tombol `Tambah Data Anak` dan `Lihat Laporan Kelurahan`.

### CRUD Data Anak

- `Create`: form bertahap untuk biodata, tanggal lahir, alamat, orang tua/wali, dan 11 dokumen.
- `Read`: detail data, status proses, catatan pemeriksa, dokumen, dan riwayat perubahan.
- `Update`: hanya dapat mengubah draft atau data yang dikembalikan oleh kecamatan.
- `Delete`: hanya menghapus draft milik kelurahan; data yang sudah dikirim memakai pembatalan/riwayat, bukan hard delete.
- Wilayah kelurahan diisi otomatis berdasarkan akun dan tidak dapat dipilih bebas.
- Umur tampil otomatis setelah tanggal lahir valid dan tidak disimpan sebagai nilai manual.

### Laporan Kelurahan

Filter laporan:

- Rentang tanggal pengajuan atau keputusan.
- Status proses.
- Status anak.
- Umur: `Semua umur` atau `Usia 18 tahun ke bawah`.

Aksi: `Tampilkan`, `Cetak`, dan `Unduh` sesuai hak akses. Laporan hanya memuat data kelurahan pengguna.

## 3. Petugas Kecamatan

### Dashboard Kecamatan

Komponen utama:

- Ringkasan jumlah pengajuan dari seluruh kelurahan dalam kecamatan.
- Antrian `Menunggu Pemeriksaan`, `Dikembalikan`, `Lolos Kecamatan`, dan `Ditolak`.
- Rekap singkat per kelurahan dengan jumlah total dan jumlah usia 18 tahun ke bawah.
- Daftar pengajuan terbaru yang membutuhkan tindakan.

### Pemeriksaan Data Anak

- Daftar hanya memuat data dari kelurahan yang berada dalam kecamatan petugas.
- Detail memakai checklist biodata, umur, wilayah, orang tua/wali, dan dokumen.
- Aksi `Kembalikan ke Kelurahan` wajib menyertakan catatan spesifik.
- Aksi `Loloskan ke Kesra` hanya tersedia jika pemeriksaan lengkap dan data usia memenuhi aturan laporan/keputusan.
- Setelah diloloskan, data dapat dilihat Kesra; sebelum itu data tidak boleh muncul di antrian Kesra.

### Laporan Kecamatan

Filter dan cetak tersedia per kelurahan, status, rentang tanggal, status anak, dan pilihan umur `Semua umur` atau `Usia 18 tahun ke bawah`. Petugas dapat melihat rekap seluruh kelurahan dalam kecamatannya, tetapi tidak dapat melihat kecamatan lain.

## 4. Petugas Kesra

### Dashboard Kesra

Komponen utama:

- Ringkasan pengajuan yang sudah lolos kecamatan.
- Antrian `Menunggu Verifikasi`, `Disetujui`, dan `Ditolak`.
- Rekap jumlah data per kecamatan dan kelurahan.
- Indikator jumlah data yang masuk kriteria usia 18 tahun ke bawah.

### Verifikasi Data Anak

- Kesra hanya dapat membuka data berstatus `diajukan_ke_kesra`.
- Detail verifikasi menampilkan seluruh data yang sudah diperiksa kecamatan, dokumen, catatan, dan riwayat audit.
- `Setujui` dan `Tolak` wajib dikonfirmasi; penolakan wajib memiliki alasan.
- Data yang disetujui untuk laporan resmi harus lolos batas usia maksimal 18 tahun pada tanggal keputusan/laporan yang ditentukan sistem.

### Laporan Kesra

Kesra dapat memfilter dan mencetak laporan per kelurahan, per kecamatan, seluruh wilayah, status keputusan, rentang tanggal, status anak, dan umur `Semua umur` atau `Usia 18 tahun ke bawah`. Akses lintas wilayah ini hanya tersedia untuk peran Kesra sesuai kewenangan.

## 5. Perhitungan umur

Tanggal lahir wajib diisi dengan tanggal yang valid dan tidak boleh berada di masa depan. Umur kalender dihitung tanpa pembulatan:

```text
umur = tahun(tanggal_acuan) - tahun(tanggal_lahir)
       - 1 jika ulang tahun tahun berjalan belum terjadi
```

`tanggal_acuan` adalah tanggal laporan saat mencetak laporan dan tanggal keputusan saat menyetujui data. Sistem menampilkan umur dalam tahun, misalnya `12 tahun`. Bila dibutuhkan untuk pemeriksaan rinci, tampilkan juga tanggal lahir.

## 6. Aturan cetak dan persetujuan umur

- Pilihan `Usia 18 tahun ke bawah` berarti `umur <= 18`, bukan hanya `umur < 18`.
- Cetak laporan resmi dan persetujuan bantuan hanya memasukkan data yang memenuhi `umur <= 18` pada tanggal acuan.
- Pilihan `Semua umur` boleh digunakan untuk audit dan laporan internal, tetapi tidak mengubah kelayakan persetujuan.
- Jika umur menjadi lebih dari 18 tahun sebelum pencetakan atau keputusan, sistem harus menandai data sebagai tidak memenuhi kriteria dan menolak aksi resmi tersebut.
- Nilai umur di layar dan laporan harus dihitung ulang dari `birth_date`; jangan menyimpan umur sebagai sumber kebenaran.

## 7. Keadaan cetak

Halaman cetak menggunakan stylesheet print yang menyembunyikan navigasi, tombol, filter interaktif, dan data sensitif yang tidak diperlukan. Header laporan memuat nama wilayah, filter umur, tanggal acuan, jumlah data, dan identitas pembuat laporan. Setiap hasil cetak harus menyimpan audit log berisi pengguna, filter, waktu, dan wilayah.