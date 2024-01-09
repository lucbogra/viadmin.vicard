<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    const TYPE = ['virtual', 'physical'];

    const STATUS = ['activated', 'not activated', 'frozen'];

    protected $casts = [
        "card_validity"         => 'date:Y-m-d',
        "card_balance"          => Money::class,
        "card_limit"            => Money::class,
        "daily_limit"           => Money::class,
        "per_transaction_limit" => Money::class,
        "card_fees"             => Money::class
    ];

    public function scopeStatus($builder, $filter) {

        $builder->where('card_status', $filter);
        
    }

    public function scopeSearch($builder, $term) {
        $builder->where("card_number", "like", "%$term%");
    }
    
    public function owner() : BelongsTo {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function accessUsers() : BelongsToMany {
        return $this->belongsToMany(User::class)->withPivot('owner', 'permission');
    }

    public function cardRequest() : BelongsTo {
        return $this->belongsTo(CardRequest::class, 'card_request_id');
    }

    public function transactions() : HasMany {
        return $this->hasMany(Transaction::class);
    }

    public function invoices(): MorphMany {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }
}
