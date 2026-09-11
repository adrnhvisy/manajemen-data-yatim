# Keputusan Frontend

## 1. Batasan teknis

- Tidak menggunakan Laravel Breeze atau starter kit autentikasi siap pakai.
- Tidak menggunakan `node_modules` untuk workflow prototipe.
- Template tetap menggunakan Blade dan JavaScript vanilla seperlunya.
- Komponen UI harus tetap dapat dipakai tanpa JavaScript; JavaScript hanya untuk interaksi tambahan.

## 2. Tailwind CSS

Gunakan Tailwind CSS v4 melalui Play CDN di layout Blade utama:

```html
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
```

Konfigurasi tema dapat ditulis di dalam halaman dengan `style="text/tailwindcss"` atau melalui CSS biasa yang dimuat oleh layout. Gunakan token warna dari [DESIGN-SYSTEM.md](DESIGN-SYSTEM.md), bukan warna acak di setiap halaman.

Play CDN dipilih agar prototipe dapat berjalan tanpa instalasi npm. Tailwind sendiri mendokumentasikan Play CDN untuk development, bukan deployment produksi. Sebelum produksi, pindahkan proses kompilasi ke Vite/CLI yang dikunci versinya dan hapus script CDN.

## 3. Animasi

Gunakan library animasi yang diminta melalui CDN berikut:

```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/animations/2.1/js/animations.min.js"></script>
```

Library tersebut membutuhkan jQuery. Jika dipakai, muat jQuery lebih dahulu:

```html
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
```

Contoh pemakaian pada elemen yang memiliki `data-anim-type="fade-in-up"`:

```html
<div class="animate-in" data-anim-type="fade-in-up" data-anim-delay="100">
    Konten
</div>
```

Animasi hanya boleh memperjelas perubahan keadaan atau urutan informasi. Hormati pengguna yang memilih reduced motion dengan menonaktifkan animasi melalui CSS:

```css
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}
```

## 4. Urutan script layout

1. Meta viewport dan stylesheet.
2. jQuery, hanya jika animasi digunakan pada halaman tersebut.
3. Library animasi CDN.
4. Script interaksi halaman milik aplikasi.

Gunakan `defer` pada script eksternal jika tidak ada kebutuhan untuk menjalankannya sebelum parsing HTML. Sumber CDN harus menggunakan HTTPS dan sebaiknya diberi Subresource Integrity ketika hash resminya tersedia.

## 5. Debounce pencarian

Pencarian daftar anak harus menggunakan debounce agar request tidak dikirim pada setiap ketikan. Jeda default adalah 300 ms setelah input terakhir. Request sebelumnya tidak perlu dibatalkan di server, tetapi hasil yang sudah tidak relevan tidak boleh menimpa hasil pencarian terbaru.

Contoh implementasi JavaScript vanilla:

```html
<input id="child-search" type="search" autocomplete="off" placeholder="Cari nama atau nomor pengajuan">
<div id="search-results" aria-live="polite"></div>

<script>
    const searchInput = document.querySelector('#child-search');
    const searchResults = document.querySelector('#search-results');
    let searchTimer;
    let latestRequest = 0;

    function debounceSearch(query) {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(async () => {
            const requestNumber = ++latestRequest;

            if (query.length < 2) {
                searchResults.replaceChildren();
                return;
            }

            const response = await fetch(`/children?search=${encodeURIComponent(query)}`, {
                headers: { Accept: 'application/json' },
            });

            if (requestNumber !== latestRequest || !response.ok) {
                return;
            }

            const data = await response.json();
            searchResults.textContent = data.html;
        }, 300);
    }

    searchInput.addEventListener('input', (event) => {
        debounceSearch(event.target.value.trim());
    });
</script>
```

Endpoint tetap wajib menerapkan authorization, validasi input, pagination, dan escaping output di server. Jangan mencari NIK dengan mengirimkan nilai plaintext; gunakan kolom hash yang memang disediakan untuk pencarian duplikasi atau tampilkan hasil yang sudah dimasking.

## 6. Catatan deployment

CDN berarti halaman membutuhkan koneksi jaringan ke penyedia aset. Untuk lingkungan pemerintahan atau jaringan terbatas, aset harus dipindahkan ke pipeline build atau disimpan di `public/` setelah lisensi dan integritasnya diverifikasi.