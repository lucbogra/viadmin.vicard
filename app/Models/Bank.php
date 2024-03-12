<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array'
    ];

    public function scopeSearch($builder, $term) {
        $builder->where("owner_name", "like", "%$term%")
                ->orWhere("bank_name", "like", "%$term%")
                ->orWhere("address", "like", "%$term%")
                ->orWhere("iban", "like", "%$term%");
    }
}
