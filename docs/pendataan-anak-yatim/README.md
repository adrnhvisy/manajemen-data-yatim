# Dokumentasi Sistem Pendataan Anak Yatim

Folder ini adalah entry point spesifikasi awal aplikasi pendataan anak yatim untuk Pemerintah Kabupaten Pelalawan.

## Alur singkat

**Kelurahan input data -> Kecamatan cek data -> Kesra verifikasi dan setujui/tolak.**

## Daftar dokumen

| Dokumen | Fungsi |
| --- | --- |
| [PRD.md](PRD.md) | Tujuan, ruang lingkup, peran, dan ukuran keberhasilan |
| [REQUIREMENTS.md](REQUIREMENTS.md) | Kebutuhan fungsional, nonfungsional, validasi, dan acceptance criteria |
| [DATABASE.md](DATABASE.md) | Entitas, field, status, relasi, dan migrasi |
| [ARCHITECTURE.md](ARCHITECTURE.md) | Struktur modul dan pola aplikasi Laravel |
| [SECURITY.md](SECURITY.md) | Perlindungan data, akses, upload, dan risiko kebijakan |
| [WORKFLOW.md](WORKFLOW.md) | Alur status dan aturan keputusan |
| [USER-STORIES.md](USER-STORIES.md) | Kebutuhan berdasarkan peran pengguna |
| [DESIGN-SYSTEM.md](DESIGN-SYSTEM.md) | Arah UI, komponen, warna, dan aksesibilitas |
| [FRONTEND-SETUP.md](FRONTEND-SETUP.md) | Keputusan Tailwind CDN, animasi, dan batasan tanpa Breeze/node_modules |
| [ROADMAP.md](ROADMAP.md) | Tahapan pekerjaan dan Definition of Done |
| [CLAUDE.md](CLAUDE.md) | Instruksi khusus Claude Code |
| [AGENTS.md](AGENTS.md) | Aturan agent untuk pekerjaan berikutnya |

## Cara memakai folder ini

1. Mulai dari `PRD.md` dan `WORKFLOW.md` untuk memahami tujuan dan proses.
2. Gunakan `REQUIREMENTS.md` sebagai daftar perilaku yang harus dibangun.
3. Gunakan `DATABASE.md` dan `ARCHITECTURE.md` sebelum membuat migration/model/controller.
4. Gunakan `SECURITY.md` untuk semua data pribadi dan dokumen.
5. Perbarui dokumen terkait ketika keputusan bisnis berubah.

## Catatan ruang lingkup

Dokumen ini baru mencakup pendataan, pemeriksaan, dan verifikasi. Integrasi Dukcapil, pencairan bantuan, tanda tangan elektronik, dan aplikasi mobile belum termasuk MVP.
