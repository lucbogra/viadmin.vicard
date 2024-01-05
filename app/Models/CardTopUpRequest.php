<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function card(): BelongsTo {

        return $this->belongsTo(Card::class);
        
    }

    public function user(): BelongsTo {

        return $this->belongsTo(User::class);
        
    }
}
