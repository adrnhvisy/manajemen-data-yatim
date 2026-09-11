<?php

namespace App\Models;

use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class ChildRecord extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = ['submission_number', 'full_name', 'nik_encrypted', 'nik_hash', 'bank_account_encrypted', 'birth_place', 'birth_date', 'gender', 'child_status', 'family_card_number_encrypted', 'address', 'rt', 'rw', 'admin_notes', 'current_status', 'office_id', 'created_by'];

    protected function casts(): array
    {
        return ['birth_date' => 'date', 'current_status' => SubmissionStatus::class];
    }

    public function office(): BelongsTo { return $this->belongsTo(Office::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
    public function parents(): HasMany { return $this->hasMany(ParentRecord::class); }
    public function guardian(): HasOne { return $this->hasOne(Guardian::class); }
    public function documents(): HasMany { return $this->hasMany(Document::class); }
    public function reviews(): HasMany { return $this->hasMany(Review::class); }
    public function statusHistories(): HasMany { return $this->hasMany(StatusHistory::class); }

    public function age(?Carbon $on = null): int
    {
        return Carbon::parse($this->birth_date)->diffInYears($on ?? now());
    }
}
