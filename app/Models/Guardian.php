<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = ['child_record_id', 'name', 'relationship', 'nik_encrypted', 'nik_hash', 'occupation'];
    public function childRecord(): BelongsTo { return $this->belongsTo(ChildRecord::class); }
}
