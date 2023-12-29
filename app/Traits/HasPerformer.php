<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasPerformer {

    public static function bootHasPerformer()
    {
        static::creating(function ($model) {
            if( !$model->user_id ) {
                $model->user_id = auth()->id();
            }
        });

    }

    public function createdBy(): BelongsTo {
        return $this->belongsTo(User::class, "user_id");
    }
}
