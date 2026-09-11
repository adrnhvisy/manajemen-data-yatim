# Architecture - Struktur Aplikasi

## 1. Keputusan awal

Aplikasi menggunakan Laravel 13 yang sudah tersedia di repository, PHP 8.3, Blade/Vite untuk antarmuka awal, Eloquent untuk akses data, Form Request untuk validasi, Policy untuk otorisasi, dan service layer untuk transisi workflow.

## 2. Modul

- **Identity**: autentikasi, role, unit kerja, sesi.
- **Wilayah**: kabupaten, kecamatan, kelurahan/desa, relasi kewenangan.
- **Pendataan**: form anak, orang tua, wali, draft, versi perubahan.
- **Dokumen**: upload, metadata, preview/download terotorisasi, penggantian versi.
- **Review**: pemeriksaan kecamatan dan verifikasi Kesra.
- **Audit**: riwayat status, keputusan, aktivitas sensitif.
- **Laporan**: dashboard agregat dan export berizin.

## 3. Struktur Laravel yang disarankan

- `app/Models`: `ChildRecord`, `ParentRecord`, `Guardian`, `Document`, `Review`, `StatusHistory`, `Office`, `AuditLog`.
- `app/Http/Controllers`: controller per modul, tipis dan mendelegasikan aturan ke service.
- `app/Http/Requests`: request terpisah untuk simpan draft, kirim, review kecamatan, dan keputusan Kesra.
- `app/Policies`: kebijakan akses per record dan dokumen.
- `app/Services`: `SubmissionWorkflowService`, `DocumentService`, `AuditService`.
- `app/Enums`: role, status, document type, decision.
- `resources/views`: layout, dashboard per role, form, review, detail, laporan.
- `database/migrations`: tabel berdasarkan urutan dependensi pada `DATABASE.md`.
- `routes/web.php`: route terkelompok middleware auth dan role.

## 4. Aturan aliran data

Controller menerima request tervalidasi, Policy memastikan akses, Service memvalidasi transisi dan menjalankan transaksi database, lalu event/audit mencatat hasilnya. View tidak boleh mengubah status secara langsung.

Operasi kirim, kembali, teruskan, setujui, dan tolak harus memakai transaksi dan mengunci record terkait agar keputusan ganda tidak terjadi.

## 5. Endpoint konseptual

- `GET/POST /pengajuan`
- `GET/PATCH /pengajuan/{id}`
- `POST /pengajuan/{id}/kirim-ke-kecamatan`
- `POST /pengajuan/{id}/pemeriksaan-kecamatan`
- `POST /pengajuan/{id}/kirim-ke-kesra`
- `POST /pengajuan/{id}/keputusan-kesra`
- `GET /pengajuan/{id}/dokumen/{document}`

Nama route final boleh berubah mengikuti konvensi implementasi, tetapi otorisasi dan transisi tetap wajib.

## 6. Pengujian

- Unit test untuk aturan transisi status.
- Feature test per role dan batas wilayah.
- Feature test upload dokumen invalid/valid.
- Test bahwa Kesra tidak dapat memproses status yang salah.
- Test audit untuk setiap keputusan.
- Test duplikasi NIK menggunakan hash.
