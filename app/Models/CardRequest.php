<?php

namespace App\Models;

use App\Traits\HasPerformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CardRequest extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    use HasPerformer;

    protected $casts = [
        'receips' => 'array'
    ];

    const STATUS = ['pending', 'cancelled', 'validated'];

    public function scopeStatus($builder, $filter) {
        $builder->where('status', $filter);
    }

    public function scopePending($query) {
        $query->where('status', 'pending');
    }

    public function scopeCancelled($query) {
        $query->where('status', 'cancelled');
    }

    public function scopeValidated($query) {
        $query->where('status', 'validated');
    }

    public function card() : HasOne {
        return $this->hasOne(Card::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


}
