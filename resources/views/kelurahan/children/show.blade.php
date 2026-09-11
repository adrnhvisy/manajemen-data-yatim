<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
@extends('layouts.app', ['heading' => 'Detail Data Anak', 'role' => 'Operator Kelurahan'])
@section('content')<h2 class="display text-3xl font-bold">Detail pengajuan</h2><div class="mt-8 rounded-3xl bg-white p-8"><p class="text-sm text-[#778078]">Nomor pengajuan</p><p class="mt-2 text-xl font-bold">{{ $childRecord->submission_number ?? 'Belum dibuat' }}</p><p class="mt-8 text-sm text-[#778078]">Nama anak</p><p class="mt-2 text-xl font-bold">{{ $childRecord->full_name ?? 'Belum ada data' }}</p></div>@endsection
