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

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saved(function ($model) {

    //         $period = today();

    //         $format = "Y-m";
        
    //         $invoice = [
    //             "customer_id"  => $model->owner->id,
    //             "period"       => $period->format($format),
    //             "currency"     => "USD",
    //             "amount"       => $isFirstCard ? config('billing.first_card_cost') : config('billing.other_cards_cost'),
    //             "card_id"      => $model->id,
    //             "payment_method" => "Bank Transfer",
    //             "status"         => "paid",
    //             "receips"        => $cardRequest->receips,
    //             "paid_at"        => $cardRequest->created_at
    //         ];
        
    //         $cardRequest->user->invoices()->create($invoice);

    //     });
    // }

    public function scopeStatus($builder, $filter) {

        $builder->where('card_status', $filter);
        
    }

    public function scopeSearch($builder, $term) {
        $builder->where("card_number", "like", "%$term%")->orWhere("nickname", "like", "%$term%");
    }
    
    public function owner() : BelongsTo {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members() : BelongsToMany {
        return $this->belongsToMany(User::class)->withPivot('owner', 'permissions');
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
