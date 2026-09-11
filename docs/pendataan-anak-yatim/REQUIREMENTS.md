# Requirements - Kebutuhan Sistem

## 1. Kebutuhan fungsional

### Akun dan kewenangan

- Sistem harus menyediakan login dan logout.
- Sistem harus mengikat pengguna ke peran: `kelurahan`, `kecamatan`, `kesra`, atau `admin`.
- Sistem harus membatasi daftar data berdasarkan wilayah dan peran.
- Sistem harus mencatat pengguna, waktu, dan tindakan penting.

### Pengajuan data

- Kelurahan dapat membuat pengajuan baru.
- Form wajib mencakup biodata anak, domisili, ayah, ibu, dan wali opsional.
- NIK anak dan NIK orang tua harus tepat 16 digit numerik.
- Status anak hanya `yatim`, `piatu`, atau `yatim piatu`.
- Jenis kelamin hanya `laki-laki` atau `perempuan`.
- Status hidup orang tua hanya `hidup` atau `meninggal`.
- Kelurahan otomatis terisi dari wilayah kerja akun dan tidak dapat dipilih bebas.
- Pengajuan dapat disimpan sebagai draft sebelum dikirim.
- Pengajuan hanya dapat dikirim jika field wajib dan semua dokumen wajib terpenuhi.

### Pemeriksaan berjenjang

- Kecamatan dapat melihat pengajuan berstatus `diajukan_ke_kecamatan` dari wilayahnya.
- Kecamatan dapat menyetujui pemeriksaan dan meneruskan ke Kesra.
- Kecamatan dapat mengembalikan pengajuan ke kelurahan dengan catatan wajib.
- Kelurahan dapat memperbaiki pengajuan yang dikembalikan dan mengirim ulang.
- Kesra hanya dapat menerima pengajuan yang sudah lolos kecamatan.
- Kesra dapat menyetujui atau menolak dengan catatan keputusan wajib.
- Data yang ditolak tidak boleh kembali ke alur aktif tanpa membuat proses revisi yang tercatat.

### Dokumen

Sistem harus mendukung satu dokumen untuk setiap jenis berikut: surat permohonan pengajuan, surat permohonan pencairan, KTP orang tua/wali, kartu keluarga, akte kelahiran atau surat keterangan lahir dari lurah, akte/surat kematian orang tua, surat pernyataan benar permohonan anak yatim, surat pernyataan kebenaran dokumen, surat pernyataan tanggung jawab penggunaan belanja bantuan sosial, rekening Bank Riau Kepri Syariah, dan pas foto 3x4 warna.

### Pencarian dan laporan

- Pengguna berwenang dapat menyaring berdasarkan status, wilayah, tanggal, dan status anak.
- Kelurahan dapat membuat, melihat, mengubah, dan menghapus draft data anak dari wilayahnya.
- Kelurahan dapat melihat dan mencetak laporan untuk wilayah kelurahannya sendiri.
- Kecamatan dapat melihat data dari kelurahan di kecamatannya, memeriksa, mengembalikan, atau meneruskan data ke Kesra.
- Kecamatan dapat melihat dan mencetak rekap per kelurahan dalam kecamatannya.
- Kesra hanya dapat memverifikasi data yang sudah lolos pemeriksaan kecamatan.
- Kesra dapat mencetak rekap per kelurahan, per kecamatan, atau seluruh wilayah sesuai kewenangan.
- Pencarian teks memakai debounce 300 ms dan hanya berjalan setelah minimal 2 karakter.
- Hasil request lama tidak boleh menimpa hasil request pencarian yang lebih baru.
- Umur dihitung otomatis dari tanggal lahir terhadap tanggal acuan laporan atau keputusan.
- Filter umur menyediakan pilihan `Semua umur` dan `Usia 18 tahun ke bawah`.
- Cetak laporan resmi dan persetujuan hanya boleh memasukkan anak dengan umur maksimal 18 tahun pada tanggal acuan.
- NIK tidak ditampilkan penuh pada daftar umum.
- Sistem menyediakan ringkasan jumlah draft, menunggu kecamatan, menunggu Kesra, disetujui, dan ditolak.
- Export data harus mengikuti hak akses dan kebijakan perlindungan data.

## 2. Kebutuhan nonfungsional

- Antarmuka responsif untuk desktop pemerintahan dan tablet.
- Validasi dilakukan di server; validasi client hanya membantu pengguna.
- Semua perubahan status bersifat transaksional dan tercatat.
- File di luar `public` dan diakses melalui endpoint berizin.
- Waktu respons halaman daftar normal ditargetkan kurang dari 3 detik pada beban MVP.
- Backup database dan dokumen mengikuti kebijakan operasional pemerintah daerah.
- Bahasa antarmuka: Bahasa Indonesia.

## 3. Aturan validasi dokumen

- Format awal: PDF, JPG, JPEG, PNG.
- Batas ukuran file ditetapkan melalui konfigurasi, disarankan maksimal 5 MB per file pada MVP.
- Sistem memeriksa MIME nyata, ukuran, nama file aman, dan menyimpan nama acak.
- Pengguna wajib memilih jenis dokumen; ekstensi file saja tidak dianggap validitas isi.

## 4. Kriteria penerimaan utama

1. Operator kelurahan membuat draft lengkap dan wilayah kelurahan otomatis terisi.
2. Pengiriman tanpa field wajib atau dokumen wajib ditolak oleh server.
3. Kecamatan dapat mengembalikan dengan alasan; kelurahan melihat alasan tersebut.
4. Pengiriman ulang membuat riwayat versi/status, bukan menghapus riwayat lama.
5. Kesra tidak dapat menyetujui pengajuan yang belum lolos kecamatan.
6. Penolakan Kesra selalu menyimpan alasan, pengguna, dan waktu.
7. Pencarian tidak mengirim request untuk setiap ketikan, menampilkan keadaan kosong untuk query kurang dari 2 karakter, dan menampilkan hasil terbaru saat beberapa request selesai tidak berurutan.
8. Perhitungan umur berubah benar ketika tanggal acuan melewati ulang tahun anak.
9. Rekap dapat berganti antara semua umur dan usia 18 tahun ke bawah tanpa mencampur hasil filter.
10. Cetak dan persetujuan menolak data yang berumur lebih dari 18 tahun pada tanggal acuan.
