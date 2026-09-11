<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $fillable = ['child_record_id', 'from_status', 'to_status', 'actor_id', 'notes', 'metadata'];
    protected function casts(): array { return ['metadata' => 'array']; }
    public function childRecord(): BelongsTo { return $this->belongsTo(ChildRecord::class); }
    public function actor(): BelongsTo { return $this->belongsTo(User::class, 'actor_id'); }
}
