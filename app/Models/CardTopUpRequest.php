<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CardTopUpRequest extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'attachments' => 'array'
    ];

    public function scopeStatus($builder, $filter) {

        $builder->where('status', $filter);
        
    }

    public function scopePending($query) {
        $query->where('status', 'pending');
    }

    public function card(): BelongsTo {

        return $this->belongsTo(Card::class);
        
    }

    public function user(): BelongsTo {

        return $this->belongsTo(User::class);
        
    }

    public function transaction(): BelongsTo {

        return $this->belongsTo(Transaction::class);
        
    }
}
