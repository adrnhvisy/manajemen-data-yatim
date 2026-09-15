<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'alamat';
    protected $fillable = ['alamat_lengkap', 'rt', 'rw', 'kelurahan_id'];

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}
