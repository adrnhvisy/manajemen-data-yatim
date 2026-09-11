<div>
    <!-- We must ship. - Taylor Otwell -->
@extends('layouts.app', ['heading' => $title, 'role' => 'Operator Kelurahan'])
@section('content')<h2 class="display text-3xl font-bold">{{ $title }}</h2><p class="mt-2 text-[#6f776e]">{{ $scope }}</p><div class="mt-8 rounded-3xl bg-white p-6"><div class="flex flex-wrap gap-3"><select class="rounded-2xl border border-black/10 bg-white px-4 py-3"><option>Semua umur</option><option>Usia 18 tahun ke bawah</option></select><a href="{{ route('kelurahan.laporan.print') }}" class="rounded-full bg-[#315c45] px-5 py-3 font-semibold text-white">Cetak laporan</a></div><p class="mt-10 text-sm text-[#778078]">Belum ada data laporan.</p></div>@endsection
