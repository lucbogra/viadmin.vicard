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
        "billed_cards" => "array",
        "paid_at" => "datetime",
    ];

    public function scopeUnPaids($builder) {
        $builder->whereNull("paid_at");
    }

    public function scopeStatus($builder, $status) {
        if ($status == "unpaid") {
            $builder->whereNull("paid_at");
        } else {
            $builder->whereNotNull("paid_at");
        }
    }

    public function scopeSearch($builder, $term) {
        $builder->where("invoice_number", "like", "%$term%");
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(User::class, "customer_id");
    }
}
