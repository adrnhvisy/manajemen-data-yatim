<div>
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
@extends('layouts.app', ['heading' => 'Dashboard Kesra', 'role' => 'Petugas Kesra'])
@section('content')<p class="text-sm text-[#6f776e]">Verifikasi akhir bantuan sosial</p><h2 class="display mt-1 text-3xl font-bold">Data siap diverifikasi</h2><div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">@foreach($stats as $label => $value)<x-stat-card :label="$label" :value="$value" />@endforeach</div><div class="mt-8 rounded-3xl bg-[#1f3b2d] p-6 text-white"><p class="text-sm text-[#d8ee9b]">Gate verifikasi</p><h3 class="display mt-12 text-2xl font-bold">Hanya data yang lolos Kecamatan yang masuk ke sini.</h3></div>@endsection
