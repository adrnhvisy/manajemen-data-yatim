<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ParentRecord extends Model
{
    protected $fillable = ['child_record_id', 'type', 'name', 'nik_encrypted', 'nik_hash', 'occupation', 'life_status'];
    public function childRecord(): BelongsTo { return $this->belongsTo(ChildRecord::class); }
}
