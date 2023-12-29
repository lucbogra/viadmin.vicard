<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Invoice extends Model
{
    use HasFactory;

    public function invoiceable() : MorphTo {
        return $this->morphTo();
    }

    protected $cast = [
        "amount" => Money::class
    ];
}
