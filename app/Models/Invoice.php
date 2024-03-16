<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        "receips" => "array",
        "paid_at" => "datetime",
    ];

    protected $appends = ["payment_status"];

    protected function paymentStatus(): Attribute {
        return Attribute::make(
            get: function ($value) {
                if ($this->status == 'paid') {
                    return 'Paid';
                }

                if ($this->status == 'processing') {
                    return 'Waiting For Confirmation';
                }

                return 'Pending';
            },
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // $number = AutoNumber::where('key', 'invoice')->first();

            $period = today();
            $limit  = 99999;
            $invoiceNumber = Invoice::count() + 1;

            if ($invoiceNumber > $limit) {
                $invoiceNumber = $invoiceNumber - $limit;
            }

            $invoiceNumber = "INV";
            $invoiceNumber .= $period->format('ym');
            $invoiceNumber .= Str::padLeft(($invoiceNumber), strlen($limit), '0');

            $model->invoice_number = $invoiceNumber;
        });

        // static::created(function ($model) {

        //     // $number = AutoNumber::where('key', 'invoice')->first();
        //     // $number->update(['current_number' => $number->current_number + 1]);

        // });
    }

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

    public function card(): BelongsTo {
        return $this->belongsTo(Card::class, "card_id");
    }
}
