<div>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Manajemen Data Yatim' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink: #17221c; --moss: #315c45; --lime: #d8ee9b; --paper: #f4f3ed; }
        body { font-family: 'DM Sans', sans-serif; background: var(--paper); color: var(--ink); }
        h1, h2, h3, .display { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="min-h-screen">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="hidden lg:flex flex-col justify-between bg-[#1f3b2d] p-6 text-white">
            <div>
                <a href="{{ route('home') }}" class="display text-xl font-bold tracking-tight">ruang<span class="text-[#d8ee9b]">yatim</span></a>
                <p class="mt-2 text-sm text-white/60">Pendataan bantuan sosial</p>
                <nav class="mt-12 space-y-2 text-sm">
                    <a href="{{ url()->current() }}" class="block rounded-2xl bg-white/10 px-4 py-3">Dashboard</a>
                    <a href="{{ route('kelurahan.anak.index') }}" class="block rounded-2xl px-4 py-3 text-white/70 hover:bg-white/10">Data anak</a>
                    <a href="{{ route('kelurahan.laporan.index') }}" class="block rounded-2xl px-4 py-3 text-white/70 hover:bg-white/10">Laporan</a>
                </nav>
            </div>
            <div class="rounded-2xl border border-white/10 p-4 text-sm text-white/70">Mode prototipe<br><span class="text-white">Data terstruktur, proses transparan.</span></div>
        </aside>
        <main>
            <header class="flex items-center justify-between border-b border-black/5 bg-[#f4f3ed]/90 px-5 py-4 backdrop-blur lg:px-10">
                <div><p class="text-xs font-semibold uppercase tracking-[.18em] text-[#6f776e]">{{ $eyebrow ?? 'Pemerintah Kabupaten Pelalawan' }}</p><h1 class="mt-1 text-xl font-bold">{{ $heading ?? 'Dashboard' }}</h1></div>
                <div class="rounded-full bg-[#d8ee9b] px-4 py-2 text-sm font-semibold">{{ $role ?? 'Operator' }}</div>
            </header>
            <section class="px-5 py-8 lg:px-10">@yield('content')</section>
        </main>
    </div>
</body>
</html>
