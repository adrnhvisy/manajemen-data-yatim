<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
@extends('layouts.app', ['heading' => 'Dashboard Kecamatan', 'role' => 'Petugas Kecamatan'])
@section('content')<p class="text-sm text-[#6f776e]">Pusat pemeriksaan wilayah</p><h2 class="display mt-1 text-3xl font-bold">Antrian yang perlu perhatian</h2><div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">@foreach($stats as $label => $value)<x-stat-card :label="$label" :value="$value" />@endforeach</div><div class="mt-8 rounded-3xl bg-white p-6"><h3 class="display text-xl font-bold">Pengajuan masuk</h3><p class="mt-12 text-sm text-[#778078]">Belum ada data dari kelurahan dalam wilayah ini.</p></div>@endsection
