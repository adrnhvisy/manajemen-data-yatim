<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ruang Yatim | Pendataan bantuan sosial</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'DM Sans',sans-serif}.display{font-family:'Space Grotesk',sans-serif}@keyframes rise{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}.rise{animation:rise .7s ease both}.delay{animation-delay:.12s}.delay2{animation-delay:.22s}</style>
</head>
<body class="min-h-screen overflow-x-hidden bg-[#f4f3ed] text-[#17221c]">
    <header class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-10"><a href="{{ route('home') }}" class="display text-xl font-bold">ruang<span class="text-[#315c45]">yatim</span></a><a href="{{ route('kelurahan.dashboard') }}" class="rounded-full bg-[#1f3b2d] px-5 py-3 text-sm font-semibold text-white">Masuk ke aplikasi <span aria-hidden="true">↗</span></a></header>
    <main class="mx-auto max-w-7xl px-6 pb-16 pt-10 lg:px-10 lg:pt-20">
        <section class="grid items-end gap-12 lg:grid-cols-[1.1fr_.9fr]">
            <div class="rise"><p class="mb-5 text-sm font-semibold uppercase tracking-[.22em] text-[#bd713f]">Pendataan yang lebih manusiawi</p><h1 class="display max-w-3xl text-5xl font-bold leading-[.98] tracking-tight sm:text-7xl">Satu ruang untuk menjaga data <span class="text-[#315c45]">anak yatim.</span></h1><p class="mt-7 max-w-xl text-lg leading-8 text-[#5d665f]">Alur data yang rapi dari Kelurahan, pemeriksaan Kecamatan, sampai verifikasi Kesra. Terukur, terlacak, dan siap dipertanggungjawabkan.</p><div class="mt-9 flex flex-wrap gap-3"><a href="{{ route('kelurahan.dashboard') }}" class="rounded-full bg-[#315c45] px-6 py-3.5 font-semibold text-white">Lihat dashboard</a><a href="#alur" class="rounded-full border border-[#315c45]/25 px-6 py-3.5 font-semibold text-[#315c45]">Pelajari alurnya</a></div></div>
            <div class="rise delay relative overflow-hidden rounded-[2rem] bg-[#d8ee9b] p-7 lg:p-10"><div class="absolute -right-16 -top-16 h-48 w-48 rounded-full border-[28px] border-[#315c45]/15"></div><p class="text-sm font-semibold uppercase tracking-[.18em] text-[#315c45]">Hari ini</p><p class="display mt-14 text-7xl font-bold text-[#1f3b2d]">18<span class="text-3xl">+</span></p><p class="mt-2 max-w-xs text-[#315c45]">aturan usia dan status yang membantu laporan tetap konsisten.</p><div class="mt-12 border-t border-[#315c45]/20 pt-5 text-sm text-[#315c45]">Kelurahan → Kecamatan → Kesra</div></div>
        </section>
        <section id="alur" class="mt-28 border-t border-black/10 pt-12"><div class="grid gap-5 md:grid-cols-3"><article class="rise delay rounded-3xl bg-white p-7"><span class="text-sm font-bold text-[#bd713f]">01 / KELURAHAN</span><h2 class="display mt-16 text-2xl font-bold">Input & lengkapi</h2><p class="mt-3 leading-7 text-[#66716a]">Kelola draft, dokumen, data orang tua, dan kirim pengajuan ke Kecamatan.</p></article><article class="rise delay2 rounded-3xl bg-[#1f3b2d] p-7 text-white"><span class="text-sm font-bold text-[#d8ee9b]">02 / KECAMATAN</span><h2 class="display mt-16 text-2xl font-bold">Periksa & teruskan</h2><p class="mt-3 leading-7 text-white/65">Periksa data sesuai wilayah, kembalikan dengan catatan, atau teruskan ke Kesra.</p></article><article class="rise delay rounded-3xl bg-[#e7d7bd] p-7"><span class="text-sm font-bold text-[#8e5d34]">03 / KESRA</span><h2 class="display mt-16 text-2xl font-bold">Verifikasi & putuskan</h2><p class="mt-3 leading-7 text-[#6f6659]">Pastikan data lolos pemeriksaan dan memenuhi batas usia sebelum keputusan.</p></article></div></section>
    </main>
    <footer class="mx-auto flex max-w-7xl justify-between px-6 pb-8 text-sm text-[#7a827b] lg:px-10"><span>Ruang Yatim · Pelalawan</span><span>Data publik internal</span></footer>
</body>
</html>
