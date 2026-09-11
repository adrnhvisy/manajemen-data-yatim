# Design System

## 1. Arah visual

Gunakan gaya layanan publik yang tenang, jelas, dan mudah dipindai: latar netral terang, warna utama hijau tua yang terkait konteks layanan sosial/pemerintahan, aksen emas untuk status perhatian, dan warna semantik untuk keputusan. Hindari dekorasi yang mengganggu pekerjaan administratif.

## 2. Tipografi

- Font UI: gunakan font sans-serif yang tersedia secara resmi di aplikasi dan memiliki dukungan Bahasa Indonesia.
- H1 halaman: 28-32 px.
- H2 section: 20-24 px.
- Body: 14-16 px; line-height minimal 1.5.
- Label form: 13-14 px, jelas, selalu dekat dengan input.
- Jangan gunakan warna sebagai satu-satunya pembeda status.

## 3. Layout

- Header berisi nama aplikasi, unit pengguna, dan menu akun.
- Sidebar/menu menampilkan modul sesuai role.
- Halaman daftar memakai tabel responsif dengan filter status/wilayah/tanggal.
- Halaman detail memakai dua kolom: data utama dan panel status/riwayat; pada mobile menjadi satu kolom.
- Form panjang dibagi menjadi section: Biodata Anak, Domisili, Orang Tua, Wali, Dokumen, Review.
- Tombol aksi berbahaya atau final meminta konfirmasi dan catatan.

## 4. Komponen wajib

- `StatusBadge`: Draft, Menunggu Kecamatan, Perlu Perbaikan, Menunggu Kesra, Disetujui, Ditolak.
- `StepIndicator`: Kelurahan -> Kecamatan -> Kesra.
- `RequiredField`: label wajib dan pesan error dekat input.
- `DocumentChecklist`: 11 jenis dokumen, status ada/tidak/ditolak.
- `ReviewPanel`: catatan pemeriksaan dan aksi sesuai role.
- `AuditTimeline`: aktor, waktu, aksi, dan catatan.
- `MaskedValue`: NIK/rekening tidak tampil penuh di daftar.

## 5. Warna semantik

- Informasi: biru dengan kontras AA.
- Menunggu/perhatian: emas atau amber.
- Perlu perbaikan: oranye.
- Disetujui: hijau.
- Ditolak/error: merah.
- Teks utama: hampir hitam; latar: putih/abu netral.

## 6. Aksesibilitas

- Semua input punya label dan error yang terhubung secara programatik.
- Fokus keyboard terlihat jelas.
- Kontras teks minimal WCAG AA.
- Jangan mengandalkan hover untuk informasi penting.
- Ukuran target sentuh minimal sekitar 44 px.
- Tabel memiliki heading yang jelas dan alternatif tampilan mobile.

## 7. Bahasa antarmuka

Gunakan istilah konsisten: `Draf`, `Diajukan ke Kecamatan`, `Dikembalikan untuk Perbaikan`, `Diajukan ke Kesra`, `Disetujui`, `Ditolak`. Pesan error harus menyebut tindakan yang perlu dilakukan, bukan hanya "data tidak valid".
