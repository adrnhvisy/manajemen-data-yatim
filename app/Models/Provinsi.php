<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kabupaten;

class Provinsi extends Model
{
    protected $fillable = ['nama_provinsi'];

    public function kabupatens()
    {
        return $this->hasMany(Kabupaten::class);
    }
}


