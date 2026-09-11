# Struktur Modul dan Pembagian Tugas File

## 1. Prinsip pembagian

Setiap lapisan memiliki satu tanggung jawab:

- **Route** memilih endpoint, middleware, dan controller.
- **Controller** menerima request tervalidasi dan mengatur response/view; tidak memuat aturan bisnis panjang.
- **Form Request** memeriksa authorization dan validation input.
- **Policy** memeriksa role, unit kerja, wilayah, dan kemampuan terhadap record.
- **Service** menjalankan aturan bisnis, transisi status, transaksi, dan audit.
- **Resource** membentuk data aman untuk response JSON; NIK dan rekening tidak boleh ikut terbuka.
- **View** hanya menampilkan data dan form; view tidak mengubah status secara langsung.
- **Model** mendefinisikan field, cast, relationship, dan scope query.

## 2. Struktur folder yang disarankan

```text
app/
|-- Enums/
|   |-- Role.php
|   |-- SubmissionStatus.php
|   |-- ReviewDecision.php
|   `-- DocumentType.php
|-- Http/
|   |-- Controllers/
|   |   |-- Kelurahan/
|   |   |   |-- DashboardController.php
|   |   |   |-- ChildRecordController.php
|   |   |   `-- ReportController.php
|   |   |-- Kecamatan/
|   |   |   |-- DashboardController.php
|   |   |   |-- ReviewController.php
|   |   |   `-- ReportController.php
|   |   |-- Kesra/
|   |   |   |-- DashboardController.php
|   |   |   |-- VerificationController.php
|   |   |   `-- ReportController.php
|   |   `-- DocumentController.php
|   |-- Middleware/
|   |   `-- EnsureRole.php
|   |-- Requests/
|   |   |-- Kelurahan/
|   |   |   |-- StoreChildRecordRequest.php
|   |   |   |-- UpdateChildRecordRequest.php
|   |   |   `-- SubmitChildRecordRequest.php
|   |   |-- Kecamatan/
|   |   |   |-- ReviewChildRecordRequest.php
|   |   |   `-- ReportFilterRequest.php
|   |   `-- Kesra/
|   |       |-- DecideChildRecordRequest.php
|   |       `-- ReportFilterRequest.php
|   `-- Resources/
|       |-- ChildRecordResource.php
|       |-- ChildRecordCollection.php
|       |-- ReviewResource.php
|       `-- ReportResource.php
|-- Models/
|   |-- ChildRecord.php
|   |-- ParentRecord.php
|   |-- Guardian.php
|   |-- Document.php
|   |-- Review.php
|   |-- StatusHistory.php
|   |-- Office.php
|   `-- AuditLog.php
|-- Policies/
|   |-- ChildRecordPolicy.php
|   |-- DocumentPolicy.php
|   `-- ReportPolicy.php
`-- Services/
    |-- SubmissionWorkflowService.php
    |-- DocumentService.php
    |-- ReportService.php
    `-- AuditService.php

resources/views/
|-- layouts/
|   |-- app.blade.php
|   |-- guest.blade.php
|   `-- print.blade.php
|-- components/
|   |-- status-badge.blade.php
|   |-- step-indicator.blade.php
|   |-- document-checklist.blade.php
|   |-- review-panel.blade.php
|   `-- audit-timeline.blade.php
|-- kelurahan/
|   |-- dashboard.blade.php
|   |-- children/
|   |   |-- index.blade.php
|   |   |-- create.blade.php
|   |   |-- edit.blade.php
|   |   `-- show.blade.php
|   `-- reports/index.blade.php
|-- kecamatan/
|   |-- dashboard.blade.php
|   |-- reviews/index.blade.php
|   |-- reviews/show.blade.php
|   `-- reports/index.blade.php
`-- kesra/
    |-- dashboard.blade.php
    |-- verifications/index.blade.php
    |-- verifications/show.blade.php
    `-- reports/index.blade.php

database/migrations/
|-- *_create_offices_table.php
|-- *_add_office_id_to_users_table.php
|-- *_create_child_records_table.php
|-- *_create_parents_table.php
|-- *_create_guardians_table.php
|-- *_create_documents_table.php
|-- *_create_reviews_table.php
|-- *_create_status_histories_table.php
`-- *_create_audit_logs_table.php

routes/
|-- web.php
`-- console.php
```

## 3. Tanggung jawab per bagian

### Kelurahan

- `Kelurahan/DashboardController`: ringkasan milik kelurahan yang sedang login.
- `Kelurahan/ChildRecordController`: CRUD draft dan data yang dikembalikan; memanggil request, policy, dan service.
- `Kelurahan/ReportController`: filter, preview, dan cetak laporan kelurahan.
- `Requests/Kelurahan`: validasi biodata, dokumen, wilayah otomatis, dan pengiriman.
- `views/kelurahan`: dashboard, daftar, form, detail, dan laporan kelurahan.

### Kecamatan

- `Kecamatan/DashboardController`: antrian dan rekap kelurahan dalam kecamatan user.
- `Kecamatan/ReviewController`: membuka checklist, mengembalikan, atau meloloskan data ke Kesra.
- `Kecamatan/ReportController`: laporan yang dikelompokkan per kelurahan dalam kecamatan.
- `Requests/Kecamatan`: validasi catatan pengembalian, keputusan pemeriksaan, dan filter laporan.
- `views/kecamatan`: dashboard, daftar pemeriksaan, detail review, dan laporan.

### Kesra

- `Kesra/DashboardController`: antrian data yang sudah lolos kecamatan.
- `Kesra/VerificationController`: verifikasi akhir, persetujuan, atau penolakan.
- `Kesra/ReportController`: laporan per kelurahan, per kecamatan, dan seluruh kewenangan Kesra.
- `Requests/Kesra`: validasi keputusan, alasan penolakan, umur, dan filter laporan.
- `views/kesra`: dashboard, verifikasi, detail, dan laporan.

## 4. Aturan lintas lapisan

1. Route tidak melakukan query database atau keputusan bisnis.
2. Controller tidak menerima `role` dari input pengguna.
3. Request memanggil Policy atau `authorize()` sebelum controller berjalan.
4. Service mengambil user terautentikasi, menentukan cakupan wilayah, mengunci record, memvalidasi status, lalu menulis audit.
5. Resource hanya menampilkan field yang diizinkan untuk role dan konteks response.
6. View menggunakan route name, `@csrf`, `@method`, dan error dari Form Request.
7. Semua perubahan status memakai `SubmissionWorkflowService`.
8. File laporan dan cetak memakai `ReportPolicy` dan `ReportService`; tidak boleh membuat jalur akses baru.

## 5. Alur satu request

```text
Route
  -> middleware auth + role
  -> Form Request authorize() + rules()
  -> Policy record/wilayah
  -> Controller tipis
  -> Service + database transaction + audit
  -> Resource atau View
```

Struktur ini mengikuti konvensi Laravel: Form Request menangani authorization/validation, controller mengorkestrasi request, dan Resource mentransformasikan response tanpa membuka field sensitif.
