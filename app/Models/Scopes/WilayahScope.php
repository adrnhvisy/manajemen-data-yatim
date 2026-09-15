<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WilayahScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        // Superadmin & Kesra can see all data
        if ($user->hasRole(['superadmin', 'kesra'])) {
            return;
        }

        // Kecamatan: filter by kelurahan within same kecamatan
        if ($user->hasRole('kecamatan') && $user->kecamatan_id) {
            $builder->whereHas('alamatDomisili.kelurahan', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            });
            return;
        }

        // Kelurahan: filter by exact kelurahan
        if ($user->hasRole('kelurahan') && $user->kelurahan_id) {
            $builder->whereHas('alamatDomisili', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            });
        }
    }
}
