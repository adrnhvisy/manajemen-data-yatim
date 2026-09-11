<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
@extends('layouts.app', ['heading' => 'Edit Data Anak', 'role' => 'Operator Kelurahan'])
@section('content')<h2 class="display text-3xl font-bold">Edit data anak</h2><div class="mt-8 rounded-3xl bg-white p-8 text-sm text-[#778078]">Form edit akan memuat data <strong>{{ $childRecord->full_name ?? 'anak terpilih' }}</strong> setelah record tersedia.</div>@endsection
