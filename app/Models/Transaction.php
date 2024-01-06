<?php

namespace App\Models;

use App\Casts\Money;
use App\Traits\HasPerformer;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    use HasPerformer;

    protected $guarded = [];

    const TYPE = ['deposit', 'withdraw'];

    const METHOD = ['commission', 'bank transfer'];

    protected $casts = [
        "amount" => Money::class,
        "date" => 'date:Y-m-d',
    ];

    public function card() : BelongsTo {
        return $this->belongsTo(Card::class);
    }

    public function scopeDeposit($query) {
        $query->where('type', 'deposit');
    }

    public function scopeWithdraw($query) {
        $query->where('type', 'withdraw');
    }
}
