<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;
    // use SoftDeletes;

    protected $guarded = [];

    public function invoiceable() : MorphTo {
        return $this->morphTo();
    }

    protected $casts = [
        "amount" => Money::class,
        "billed_cards" => "array"
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(User::class, "customer_id");
    }
}
