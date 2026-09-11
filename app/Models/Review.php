<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['child_record_id', 'reviewer_id', 'stage', 'decision', 'notes'];
    public function childRecord(): BelongsTo { return $this->belongsTo(ChildRecord::class); }
    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewer_id'); }
}
