<?php

namespace App\Models;

use App\Traits\HasPerformer;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardRequest extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    use HasPerformer;


    const STATUS = ['pending', 'cancelled', 'validated'];

    public function card() : HasOne {
        return $this->hasOne(Card::class);
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

}
