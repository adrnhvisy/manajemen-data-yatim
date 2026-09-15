<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $fillable = ['kecamatan_id', 'nama_kelurahan', 'kode_pos'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function alamat()
    {
        return $this->hasMany(Alamat::class);
    }
}
