<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['child_record_id', 'document_type', 'disk', 'path', 'original_name', 'mime_type', 'size', 'checksum', 'uploaded_by', 'uploaded_at', 'is_current'];
    protected function casts(): array { return ['uploaded_at' => 'datetime', 'is_current' => 'boolean']; }
    public function childRecord(): BelongsTo { return $this->belongsTo(ChildRecord::class); }
    public function uploader(): BelongsTo { return $this->belongsTo(User::class, 'uploaded_by'); }
}
