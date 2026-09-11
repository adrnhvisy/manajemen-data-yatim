# Database - Rancangan Struktur Data

## 0. Keputusan umum

- Database relasional: gunakan driver yang disetujui proyek (SQLite untuk lokal, PostgreSQL/MySQL untuk deployment).
- Primary key internal dapat berupa UUID/ULID; identifier pada URL tidak boleh membocorkan urutan data.
- Semua tabel transaksi memiliki timestamps; data utama anak menggunakan soft delete agar riwayat pemeriksaan tetap dapat diaudit.
- Nilai sensitif seperti NIK, nomor KK, dan rekening tidak disimpan sebagai plaintext.

## 0.1 Relasi inti

```mermaid
erDiagram
	OFFICES ||--o{ USERS : assigns
	OFFICES ||--o{ CHILD_RECORDS : owns
	OFFICES ||--o{ OFFICES : contains
	USERS ||--o{ CHILD_RECORDS : creates
	CHILD_RECORDS ||--o{ PARENTS : has
	CHILD_RECORDS ||--o| GUARDIANS : has
	CHILD_RECORDS ||--o{ DOCUMENTS : stores
	CHILD_RECORDS ||--o{ REVIEWS : receives
	CHILD_RECORDS ||--o{ STATUS_HISTORIES : tracks
	USERS ||--o{ REVIEWS : performs
	USERS ||--o{ STATUS_HISTORIES : changes
	USERS ||--o{ AUDIT_LOGS : creates

	OFFICES {
		string id PK
		string parent_id FK
		string type
		string code UK
	}
	USERS {
		string id PK
		string office_id FK
		string role
	}
	CHILD_RECORDS {
		string id PK
		string office_id FK
		string created_by FK
		date birth_date
		string current_status
	}
	PARENTS {
		string id PK
		string child_record_id FK
		string type
	}
	GUARDIANS {
		string id PK
		string child_record_id FK UK
	}
	DOCUMENTS {
		string id PK
		string child_record_id FK
		string uploaded_by FK
	}
	REVIEWS {
		string id PK
		string child_record_id FK
		string reviewer_id FK
	}
	STATUS_HISTORIES {
		string id PK
		string child_record_id FK
		string actor_id FK
	}
	AUDIT_LOGS {
		string id PK
		string actor_id FK
		string auditable_id
	}
```

Satu `child_record` adalah pengajuan untuk satu anak. Orang tua, wali, dokumen, pemeriksaan, dan riwayat status tidak boleh dibuat sebagai kolom berulang di tabel anak.

## 0.2 Kamus foreign key

| Tabel | Kolom FK | Referensi | Kardinalitas | Aturan penghapusan |
| --- | --- | --- | --- | --- |
| `offices` | `parent_id` | `offices.id` | satu parent memiliki banyak child office | `restrict` untuk office yang sudah dipakai |
| `users` | `office_id` | `offices.id` | satu office memiliki banyak user | `set null` hanya saat akun dipindah/nonaktif |
| `child_records` | `office_id` | `offices.id` | satu office memiliki banyak pengajuan | `restrict` |
| `child_records` | `created_by` | `users.id` | satu user membuat banyak pengajuan | `restrict` atau `set null` sesuai kebijakan audit |
| `parents` | `child_record_id` | `child_records.id` | satu pengajuan memiliki ayah/ibu | hapus bersama hanya untuk draft |
| `guardians` | `child_record_id` | `child_records.id` | satu pengajuan memiliki nol/satu wali | hapus bersama hanya untuk draft |
| `documents` | `child_record_id` | `child_records.id` | satu pengajuan memiliki banyak dokumen | pertahankan metadata historis |
| `documents` | `uploaded_by` | `users.id` | satu user mengunggah banyak dokumen | `restrict` |
| `reviews` | `child_record_id` | `child_records.id` | satu pengajuan memiliki banyak review | pertahankan untuk audit |
| `reviews` | `reviewer_id` | `users.id` | satu user melakukan banyak review | `restrict` |
| `status_histories` | `child_record_id` | `child_records.id` | satu pengajuan memiliki banyak riwayat | pertahankan untuk audit |
| `status_histories` | `actor_id` | `users.id` | satu user menghasilkan banyak perubahan | `restrict` |
| `audit_logs` | `actor_id` | `users.id` | satu user memiliki banyak log | nullable bila aksi sistem |

`audit_logs.auditable_type + auditable_id` adalah relasi polymorphic dan tidak memakai foreign key database biasa. Semua relasi Eloquent harus memakai nama yang sama dengan kamus ini agar query, Policy, Resource, dan eager loading konsisten.

## 1. Prinsip

Gunakan UUID atau ULID sebagai identifier publik, NIK dan nomor rekening sebagai string terenkripsi/terproteksi sesuai kebijakan, serta foreign key untuk menjaga konsistensi wilayah dan proses. Nilai status menggunakan enum aplikasi atau tabel referensi yang tervalidasi.

## 2. Entitas inti

### `users`

`id` (PK), `name`, `email` (unique), `password`, `role`, `office_id` (FK nullable), `is_active`, `last_login_at`, timestamps.

`role` dibatasi ke `kelurahan`, `kecamatan`, `kesra`, atau `admin`. Bila role berkembang, pindahkan ke tabel referensi/role terpisah.

### `offices`

`id` (PK), `name`, `type` (`kelurahan`, `kecamatan`, `kesra`), `parent_id` (self-FK nullable), `code` (unique), `is_active`, timestamps.

Struktur `parent_id` mengikat kelurahan ke kecamatan dan kecamatan ke wilayah kabupaten/Kesra.

### `child_records`

`id` (PK), `submission_number` (unique), `full_name`, `nik_encrypted`, `nik_hash`, `bank_account_encrypted`, `birth_place`, `birth_date`, `gender`, `child_status`, `family_card_number_encrypted`, `admin_notes`, `address`, `rt`, `rw`, `office_id` (FK), `created_by` (FK), `current_status`, timestamps, `deleted_at`.

Umur tidak disimpan sebagai kolom karena harus dihitung dari `birth_date` terhadap tanggal acuan laporan atau keputusan. Query laporan memakai batas tanggal lahir yang ekuivalen dengan umur `<= 18` pada tanggal acuan.

`nik_hash` digunakan untuk pencarian duplikasi tanpa membuka nilai NIK. `office_id` adalah kelurahan pemilik data.

### `parents`

`id` (PK), `child_record_id` (FK), `type` (`father`, `mother`), `name`, `nik_encrypted`, `nik_hash`, `occupation`, `life_status`, timestamps.

Tambahkan unique constraint `child_record_id + type` agar satu anak tidak memiliki dua baris ayah atau dua baris ibu pada pengajuan yang sama.

### `guardians`

`id` (PK), `child_record_id` (FK unique), `name`, `relationship`, `nik_encrypted`, `nik_hash`, `occupation`, timestamps. Seluruh field nullable karena wali opsional.

### `documents`

`id` (PK), `child_record_id` (FK), `document_type`, `disk`, `path`, `original_name`, `mime_type`, `size`, `checksum`, `uploaded_by` (FK), `uploaded_at`, `is_current`, timestamps.

Unique constraint yang disarankan: `child_record_id + document_type + is_current` melalui aturan aplikasi/transaksi.

### `reviews`

`id` (PK), `child_record_id` (FK), `reviewer_id` (FK), `stage` (`kecamatan`, `kesra`), `decision` (`forward`, `return`, `approve`, `reject`), `notes`, `created_at`.

### `status_histories`

`id` (PK), `child_record_id` (FK), `from_status`, `to_status`, `actor_id` (FK), `notes`, `metadata` (JSON nullable), `created_at`.

### `audit_logs`

`id` (PK), `actor_id` (FK nullable), `action`, `auditable_type`, `auditable_id`, `ip_address`, `user_agent`, `changes` (JSON nullable), `created_at`.

`auditable_type` dan `auditable_id` membentuk relasi polymorphic. Audit log bersifat append-only: aplikasi tidak boleh mengubah atau menghapusnya dari UI.

## 3. Status pengajuan

`draft` -> `diajukan_ke_kecamatan` -> `dikembalikan_ke_kelurahan` -> `diajukan_ke_kecamatan` -> `lolos_kecamatan` -> `diajukan_ke_kesra` -> `disetujui` atau `ditolak_kesra`.

Status `dibatalkan` dapat ditambahkan setelah kebutuhan pembatalan disepakati. Transisi wajib diperiksa di service/policy, bukan hanya di tampilan.

## 4. Indeks dan integritas

- Index `current_status`, `office_id`, `created_at`, `submission_number`.
- Index gabungan `office_id + current_status` untuk daftar kerja per unit.
- Index `child_record_id + created_at` pada riwayat, review, dan dokumen.
- Unique hash NIK anak untuk mencegah duplikasi aktif, dengan kebijakan pengecualian yang diaudit.
- Foreign key wajib memakai aksi yang disepakati per tabel; hindari cascade delete pada data yang sudah masuk proses resmi.
- Foreign key cascade hanya pada data anak yang belum masuk proses resmi; data historis sebaiknya dipertahankan.
- Semua tanggal disimpan dalam UTC dan ditampilkan dalam zona waktu operasional Riau.
- Jangan log nilai NIK, rekening, atau isi dokumen.

## 5. Migrasi bertahap

1. Wilayah, users, dan roles.
2. Child records, parents, guardians.
3. Documents dan storage metadata.
4. Reviews, status histories, audit logs.
5. Index, constraints, dan data master.
