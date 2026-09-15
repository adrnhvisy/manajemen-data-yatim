# Architecture Document — Sistem Manajemen Data Anak Yatim

**Versi:** 2.0  
**Stack Final:** Laravel 13.31.0 / PHP 8.3 / SQLite / Filament v4 (Multi-panel) / Spatie Permission & MediaLibrary / Maatwebsite Excel / Barryvdh DomPDF  
**Target Pembaca:** Software Architect, Developer, & AI Coding Assistant.

---

## 1. Struktur Folder Project & Custom Locations

Berikut adalah peta struktur direktori lengkap untuk memastikan penempatan file sesuai konvensi arsitektur Laravel & Filament v4:

```
app/
├── Enums/
│   - JenisKelamin.php
│   - StatusAnak.php
│   - StatusData.php
│   - JenisOrangTua.php
│   - StatusVerifikasiDokumen.php
│   - UserRole.php
├── Filament/
│   ├── Admin/
│   │   ├── AdminPanelProvider.php
│   │   ├── Resources/
│   │   │   ├── ProvinsiResource.php
│   │   │   ├── KabupatenResource.php
│   │   │   ├── KecamatanResource.php
│   │   │   ├── KelurahanResource.php
│   │   │   ├── UserResource.php
│   │   │   ├── KategoriDokumenResource.php
│   │   │   ├── AnakResource.php
│   │   │   └── AuditLogResource.php
│   │   └── Pages/
│   │       └── Dashboard.php
│   │   └── Widgets/
│   │       └── StatsOverview.php
│   ├── Kelurahan/
│   │   ├── KelurahanPanelProvider.php
│   │   ├── Resources/
│   │   │   └── AnakResource.php
│   │   └── Pages/
│   │       └── Dashboard.php
│   ├── Kecamatan/
│   │   ├── KecamatanPanelProvider.php
│   │   ├── Resources/
│   │   │   └── AnakResource.php
│   │   └── Pages/
│   │       └── Dashboard.php
│   └── Kesra/
│       ├── KesraPanelProvider.php
│       ├── Resources/
│       │   └── AnakResource.php
│       └── Pages/
│           └── Dashboard.php
├── Models/
│   ├── Provinsi.php
│   ├── Kabupaten.php
│   ├── Kecamatan.php
│   ├── Kelurahan.php
│   ├── User.php
│   ├── Alamat.php
│   ├── Anak.php
│   ├── OrangTua.php
│   ├── Wali.php
│   ├── KategoriDokumen.php
│   ├── DokumenAnak.php
│   ├── StatusHistori.php
│   └── AuditLog.php
├── Observers/
│   ├── AnakObserver.php
│   └── UserObserver.php
├── Policies/
│   ├── AnakPolicy.php
│   ├── UserPolicy.php
│   ├── ProvinsiPolicy.php
│   ├── KabupatenPolicy.php
│   ├── KecamatanPolicy.php
│   ├── KelurahanPolicy.php
│   └── KategoriDokumenResourcePolicy.php
├── Scopes/
│   └── WilayahScope.php
├── Services/
│   ├── ApprovalService.php
│   ├── DokumenService.php
│   └── ExportService.php
├── Exports/
│   └── RekapAnakExport.php
database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    ├── RoleAndPermissionSeeder.php
    ├── WilayahSeeder.php
    ├── KategoriDokumenSeeder.php
    └── UserSeeder.php
storage/
└── app/
    └── public/
        └── dokumen-anak/
```

---

## 2. Pola Service Layer untuk Logic Status Approval

Untuk menjaga agar Controller / Filament Resource tidak gemuk (*fat controllers/resources*) dan memastikan aturan state machine berjalan konsisten, seluruh proses transisi status, validasi level, dan pembuatan riwayat histori dipusatkan pada **`ApprovalService`**.

### Class: `app/Services/ApprovalService.php`

```php
namespace App\Services;

use App\Models\Anak;
use App\Models\StatusHistori;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApprovalService
{
    /**
     * Submit data dari Kelurahan ke Kecamatan
     */
    public function submitToKecamatan(Anak $anak, User $user, ?string $keterangan = null): void
    {
        if ($anak->status_data !== 'Draft') {
            throw ValidationException::withMessages([
                'status_data' => 'Hanya data berstatus Draft yang dapat diajukan.',
            ]);
        }

        // Validasi kelengkapan dokumen wajib
        app(DokumenService::class)->validateDokumenWajib($anak);

        DB::transaction(function () use ($anak, $user, $keterangan) {
            $statusLama = $anak->status_data;
            $anak->update([
                'status_data' => 'Pending',
            ]);

            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => $statusLama,
                'status_baru' => 'Pending',
                'level' => 'kecamatan',
                'keterangan' => $keterangan ?? 'Diajukan oleh kelurahan ke kecamatan.',
                'created_by' => $user->id,
            ]);
        });
    }

    /**
     * Approval / Rejection oleh Kecamatan
     */
    public function processKecamatan(Anak $anak, User $user, bool $isApproved, string $keterangan): void
    {
        if ($anak->status_data !== 'Pending' || $this->getCurrentLevel($anak) !== 'kecamatan') {
            throw ValidationException::withMessages([
                'status_data' => 'Data tidak berada dalam antrean verifikasi kecamatan.',
            ]);
        }

        if (!$isApproved && blank($keterangan)) {
            throw ValidationException::withMessages([
                'keterangan' => 'Penolakan WAJIB diisi keterangan alasannya.',
            ]);
        }

        DB::transaction(function () use ($anak, $user, $isApproved, $keterangan) {
            $statusLama = $anak->status_data;
            
            if ($isApproved) {
                // Lanjut ke level Kesra, status data tetap Pending
                $anak->update(['status_data' => 'Pending']);
                $statusBaru = 'Pending';
                $nextLevel = 'kesra';
            } else {
                $anak->update(['status_data' => 'Ditolak']);
                $statusBaru = 'Ditolak';
                $nextLevel = 'ditolak';
            }

            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => $statusLama,
                'status_baru' => $statusBaru,
                'level' => $nextLevel,
                'keterangan' => $keterangan,
                'created_by' => $user->id,
            ]);
        });
    }

    /**
     * Approval / Rejection Final oleh Kesra
     */
    public function processKesra(Anak $anak, User $user, bool $isApproved, string $keterangan): void
    {
        if ($anak->status_data !== 'Pending' || $this->getCurrentLevel($anak) !== 'kesra') {
            throw ValidationException::withMessages([
                'status_data' => 'Data tidak berada dalam antrean persetujuan Kesra.',
            ]);
        }

        if (!$isApproved && blank($keterangan)) {
            throw ValidationException::withMessages([
                'keterangan' => 'Penolakan final WAJIB diisi keterangan alasannya.',
            ]);
        }

        DB::transaction(function () use ($anak, $user, $isApproved, $keterangan) {
            $statusLama = $anak->status_data;
            
            if ($isApproved) {
                $anak->update(['status_data' => 'Disetujui']);
                $statusBaru = 'Disetujui';
                $nextLevel = 'selesai';
            } else {
                $anak->update(['status_data' => 'Ditolak']);
                $statusBaru = 'Ditolak';
                $nextLevel = 'ditolak';
            }

            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => $statusLama,
                'status_baru' => $statusBaru,
                'level' => $nextLevel,
                'keterangan' => $keterangan,
                'created_by' => $user->id,
            ]);
        });
    }

    private function getCurrentLevel(Anak $anak): ?string
    {
        $lastHistori = $anak->statusHistori()->latest()->first();
        return $lastHistori?->level;
    }
}
```

---

## 3. Implementasi Global Scope & Observer untuk Multi-Tenant Wilayah

Isolasi data wilayah diterapkan menggunakan **Eloquent Global Scope (`WilayahScope`)** yang dikombinasikan dengan **`AnakObserver`** untuk otomatisasi pengisian `created_by` dan `alamat_domisili_id` atau relasi wilayah.

### Kerangka `app/Scopes/WilayahScope.php`

```php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class WilayahScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        // Superadmin & Kesra melihat akses global (tanpa filter wilayah)
        if ($user->hasRole(['superadmin', 'kesra'])) {
            return;
        }

        // Role Kecamatan: melihat anak yang alamat domisilinya berada dalam kecamatan user
        if ($user->hasRole('kecamatan') && $user->kecamatan_id) {
            $builder->whereHas('alamatDomisili.kelurahan', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            });
            return;
        }

        // Role Kelurahan: melihat anak yang alamat domisilinya persis di kelurahan user
        if ($user->hasRole('kelurahan') && $user->kelurahan_id) {
            $builder->whereHas('alamatDomisili', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
            return;
        }
    }
}
```

### Kerangka `app/Observers/AnakObserver.php`

```php
namespace App\Observers;

use App\Models\Anak;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnakObserver
{
    public function creating(Anak $anak): void
    {
        if (Auth::check()) {
            $anak->created_by = Auth::id();
        }

        // Generate nomor registrasi otomatis misal: YATIM-YYYYMM-XXXX
        if (blank($anak->no_registrasi)) {
            $anak->no_registrasi = 'YATIM-' . date('Ym') . '-' . strtoupper(Str::random(5));
        }
    }
}
```

---

## 4. Daftar Filament Resource & Field Utama per Panel

### A. Panel Admin (`/admin`) — Superadmin
1. **`ProvinsiResource`**: `nama_provinsi` (TextInput, required, unique)
2. **`KabupatenResource`**: `provinsi_id` (Select), `nama_kabupaten` (TextInput)
3. **`KecamatanResource`**: `kabupaten_id` (Select), `nama_kecamatan` (TextInput)
4. **`KelurahanResource`**: `kecamatan_id` (Select), `nama_kelurahan` (TextInput), `kode_pos` (TextInput, char 5)
5. **`UserResource`**: `name`, `email`, `password`, `provinsi_id`, `kabupaten_id`, `kecamatan_id`, `kelurahan_id`, `roles` (Spatie Multi-select)
6. **`KategoriDokumenResource`**: `nama_dokumen`, `is_wajib` (Toggle)
7. **`AnakResource`**: Full CRUD akses global, monitoring seluruh status data.
8. **`AuditLogResource`**: Read-only log aktivitas sistem.

---

### B. Panel Kelurahan (`/kelurahan`) — Admin Kelurahan
- **`AnakResource`** (Data Anak & Pengajuan):
  - **Biodata Anak**: `nama_lengkap`, `nik` (16 char), `no_kk` (16 char), `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin` (Select: Laki-laki/Perempuan), `status_anak` (Select: Yatim/Piatu/Yatim Piatu), `no_rekening`, `catatan`.
  - **Alamat Domisili**: `alamat_lengkap`, `rt`, `rw`, `kelurahan_id` (Auto-filled / Default locked ke kelurahan user).
  - **Orang Tua**: Repeater / Field Ayah (`nama`, `nik`, `status_hidup`, `pekerjaan`) & Ibu (`nama`, `nik`, `status_hidup`, `pekerjaan`).
  - **Wali** (Conditional): `nama`, `nik`, `hubungan_dengan_anak`, `pekerjaan`.
  - **Relation Manager Dokumen**: Upload 11 kategori dokumen wajib berdasarkan `kategori_dokumen`.
  - **Custom Action**: Tombol **"Ajukan ke Kecamatan"** (memanggil `ApprovalService::submitToKecamatan`).

---

### C. Panel Kecamatan (`/kecamatan`) — Admin Kecamatan
- **`AnakResource`** (Verifikasi Wilayah Kecamatan):
  - List View terfilter otomatis oleh `WilayahScope` untuk wilayah kecamatannya dengan status `Pending` (level kecamatan).
  - **Custom Actions di Tabel / Halaman View**:
    - **Approve Kecamatan**: Membuka modal form konfirmasi opsional keterangan, lalu memanggil `ApprovalService::processKecamatan(..., true, ...)`.
    - **Reject Kecamatan**: Membuka modal form keterangan penolakan (Wajib), lalu memanggil `ApprovalService::processKecamatan(..., false, $keterangan)`.

---

### D. Panel Kesra (`/kesra`) — Admin Kesra
- **`AnakResource`** (Persetujuan Final Kesra):
  - List View menampilkan data yang sudah lolos verifikasi kecamatan (level kesra / pending kesra).
  - **Custom Actions**:
    - **Approve Final (Setujui)**: Memanggil `ApprovalService::processKesra(..., true, ...)`.
    - **Reject Final (Tolak)**: Memanggil `ApprovalService::processKesra(..., false, $keterangan)`.
  - **Export Action**: Export data rekapitulasi excel/PDF.

---

## 5. Daftar Policy dan Matrix Akses Role x Aksi

Berikut adalah matriks otorisasi resource `Anak`:

| Aksi / Method Policy | Superadmin | Kelurahan | Kecamatan | Kesra |
|----------------------|------------|-----------|-----------|-------|
| `viewAny`            | ✅ (Semua) | ✅ (Wilayah Kelurahan) | ✅ (Wilayah Kecamatan) | ✅ (Semua Pending/Disetujui) |
| `view`               | ✅         | ✅ (Milik Wilayahnya) | ✅ (Milik Wilayahnya) | ✅ |
| `create`             | ✅         | ✅        | ❌        | ❌    |
| `update`             | ✅         | ✅ (Hanya status `Draft` / `Ditolak`) | ❌ | ❌ |
| `delete`             | ✅         | ✅ (Hanya status `Draft`) | ❌ | ❌ |
| `approveKecamatan`   | ✅         | ❌        | ✅        | ❌    |
| `approveKesra`       | ✅         | ❌        | ❌        | ✅    |

---

## 6. Strategi Penamaan Branch & Commit Convention

### Branching Model (Git Flow Sederhana)
- `main` / `master`: Production-ready branch.
- `develop`: Integration branch untuk fitur baru.
- `feature/<task-name>`: Branch per task/fitur (contoh: `feature/setup-approval-service`, `feature/filament-kelurahan-panel`).

### Commit Convention (Conventional Commits)
Gunakan format berikut untuk setiap commit message:
```
<type>(<scope>): <short summary>
```
* **Types**:
  - `feat`: Menambahkan fitur baru.
  - `fix`: Memperbaiki bug.
  - `refactor`: Perubahan kode yang bukan bug maupun fitur (perbaikan struktur).
  - `docs`: Perubahan dokumentasi (PRD, Architecture, README).
  - `chore`: Konfigurasi build, update dependencies, migration setup.
* **Contoh**:
  - `feat(service): implement approval service for multi-level workflow`
  - `fix(scope): fix kecamatan query scope filtering`
  - `chore(database): create migrations for wilayah and anak`

---

## 7. Urutan Pengerjaan yang Direkomendasikan (Task Dependency)

1. **Task 1: Konfigurasi Database & Migrasi Dasar** (Blocking: Semua)
   - Setup migration `provinsi`, `kabupaten`, `kecamatan`, `kelurahan`, `users`, `alamat`, `anak`, `orang_tua`, `wali`, `kategori_dokumen`, `dokumen_anak`, `status_histori`, `audit_logs`.
2. **Task 2: Packages & Seeder Setup** (Blocking: Task 3, 4)
   - Install & publish Spatie Permission & MediaLibrary.
   - Buat seeder untuk `RoleAndPermissionSeeder`, `WilayahSeeder`, `KategoriDokumenSeeder`, dan `UserSeeder`.
3. **Task 3: Core Models, Observers, & Global Scopes** (Blocking: Task 5, 6)
   - Implementasi `WilayahScope` dan `AnakObserver`.
   - Setup relasi antar model secara lengkap.
4. **Task 4: Business Logic Service Layer** (Blocking: Task 6)
   - Implementasi `ApprovalService.php` untuk menangani state machine approval.
5. **Task 5: Filament Panel Providers & Superadmin Resources** (Blocking: Task 6)
   - Setup 4 Panel (`Admin`, `Kelurahan`, `Kecamatan`, `Kesra`).
   - Buat master data resources di panel admin.
6. **Task 6: Panel Resources, Actions, & Policies** (Blocking: Task 7)
   - Implementasi `AnakResource` di masing-masing panel beserta Form Schema, Table columns, dan Custom Action workflow.
   - Daftarkan `AnakPolicy`.
7. **Task 7: Export & Testing**
   - Implementasi Maatwebsite Excel / DomPDF export.
   - Tulis unit/feature test untuk validasi workflow dan scoping wilayah.

Dokumen arsitektur ini siap digunakan sebagai acuan teknis penuh oleh developer maupun AI coding assistant dalam mengimplementasikan kode secara terstruktur dan bebas ambiguitas.
