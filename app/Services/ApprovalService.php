<?php

namespace App\Services;

use App\Models\Anak;
use App\Models\StatusHistori;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApprovalService
{
    public function submitToKecamatan(Anak $anak, User $user, ?string $keterangan = null): void
    {
        if ($anak->status_data !== 'Draft') {
            throw ValidationException::withMessages([
                'status_data' => 'Hanya data berstatus Draft yang dapat diajukan.',
            ]);
        }

        app(DokumenService::class)->validateDokumenWajib($anak);

        DB::transaction(function () use ($anak, $user, $keterangan) {
            $statusLama = $anak->status_data;
            $anak->update([
                'status_data' => 'Pending',
            ]);

            StatusHistori::create([
                'anak_id' => $anak->id,
                'status_lama' => $statusLama,
                'status_baru' => 'Pending',
                'level' => 'kecamatan',
                'keterangan' => $keterangan ?? 'Diajukan oleh kelurahan ke kecamatan.',
                'user_id' => $user->id,
            ]);
        });
    }
}
