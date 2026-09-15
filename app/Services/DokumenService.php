<?php

namespace App\Services;

use App\Models\Anak;
use App\Models\KategoriDokumen;
use Illuminate\Validation\ValidationException;

class DokumenService
{
    public function validateDokumenWajib(Anak $anak): void
    {
        $wajibIds = KategoriDokumen::where('is_wajib', true)->pluck('id');
        $uploadedIds = $anak->dokumenAnaks()->pluck('kategori_dok_id');

        $missing = $wajibIds->diff($uploadedIds);

        if ($missing->isNotEmpty()) {
            throw ValidationException::withMessages([
                'dokumen' => 'Semua dokumen wajib (11 kategori) harus diunggah sebelum mengajukan data.',
            ]);
        }
    }
}
