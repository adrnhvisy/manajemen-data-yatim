<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Provinsi;
use App\Models\Kecamatan;

class Kabupaten extends Model
{
    protected $fillable = ['provinsi_id', 'nama_kabupaten'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class);
    }
}
