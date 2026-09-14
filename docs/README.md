# Dokumentasi Proyek - Manajemen Data Anak Yatim

## Entry Point Dokumentasi

Selamat datang di dokumentasi proyek website manajemen data anak yatim.

### Panduan Membaca Dokumentasi

1. **Mulai dari sini**: README.md (file ini)
2. **Pahami produk**: PRD.md
3. **Ketahui kebutuhan**: REQUIREMENTS.md
4. **Struktur data**: DATABASE.md
5. **Arsitektur**: ARCHITECTURE.md
6. **Keamanan**: SECURITY.md
7. **Alur bisnis**: WORKFLOW.md
8. **User stories**: USER-STORIES.md
9. **UI consistency**: DESIGN-SYSTEM.md
10. **Timeline**: ROADMAP.md

### File Penting untuk Developer

- **CLAUDE.md** - Instruksi untuk Claude Code Assistant
- **AGENTS.md** - Aturan dan konfigurasi agent

### Stack Teknologi

- **Backend**: Laravel 11 (PHP 8.3+)
- **Frontend**: Blade Template / Vue.js
- **Database**: MySQL/PostgreSQL
- **Build Tool**: Vite
- **Testing**: PHPUnit

### Quick Start

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start development server
php artisan serve
npm run dev
```

### Struktur Folder Dokumentasi

```
docs/
├── README.md              # Entry point
├── PRD.md                 # Product requirements
├── REQUIREMENTS.md        # System requirements
├── DATABASE.md            # Database schema
├── ARCHITECTURE.md        # System architecture
├── SECURITY.md            # Security guidelines
├── WORKFLOW.md            # Business workflow
├── USER-STORIES.md        # User stories
├── DESIGN-SYSTEM.md       # UI/UX guidelines
├── ROADMAP.md             # Project roadmap
├── CLAUDE.md              # AI instructions
└── AGENTS.md              # Agent rules
```

### Kontribusi

Saat menambahkan fitur atau membuat perubahan:

1. Update dokumentasi terkait
2. Follow panduan di CLAUDE.md
3. Ikuti SECURITY.md guidelines
4. Test sebelum commit

---

**Last Updated**: 2026-09-14
**Status**: In Development
