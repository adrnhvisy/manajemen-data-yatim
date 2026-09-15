<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\WilayahScope;

class Anak extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'anak';
    protected $fillable = [
        'no_registrasi', 'nama_lengkap', 'no_kk', 'nik', 'tempat_lahir',
        'tanggal_lahir', 'jenis_kelamin', 'status_anak', 'no_rekening',
        'catatan', 'status_data', 'alamat_domisili_id', 'created_by'
    ];

    public function alamatDomisili()
    {
        return $this->belongsTo(Alamat::class, 'alamat_domisili_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function orangTuas()
    {
        return $this->hasMany(OrangTua::class);
    }

    public function walis()
    {
        return $this->hasMany(Wali::class);
    }

    public function dokumenAnaks()
    {
        return $this->hasMany(DokumenAnak::class);
    }

    public function statusHistori()
    {
        return $this->hasMany(StatusHistori::class);
    }

    public function scopeAktif()
    {
        return $this->where('status_data', 'aktif');
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new WilayahScope);
    }
}
