@extends('layouts.app', ['heading' => 'Dashboard Kelurahan', 'role' => 'Operator Kelurahan'])
@section('content')
<div class="flex flex-wrap items-end justify-between gap-4"><div><p class="text-sm text-[#6f776e]">Wilayah kerja Anda</p><h2 class="display mt-1 text-3xl font-bold">Kelurahan Pangkalan Kerinci</h2></div><a href="{{ route('kelurahan.anak.create') }}" class="rounded-full bg-[#315c45] px-5 py-3 font-semibold text-white">+ Tambah data anak</a></div>
<div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">@foreach($stats as $label => $value)<x-stat-card :label="$label" :value="$value" />@endforeach</div>
<div class="mt-8 rounded-3xl bg-white p-6"><h3 class="display text-xl font-bold">Pekerjaan terbaru</h3><p class="mt-12 text-sm text-[#778078]">Belum ada pengajuan. Mulai dengan menambahkan data anak.</p></div>
@endsection
