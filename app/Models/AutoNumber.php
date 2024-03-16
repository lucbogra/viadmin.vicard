<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoNumber extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saved(function ($model) {

    //         if (strlen($model->current_number + 1) === ($model->max_length + 1)) {
    //             $model->current_number = 1;
    //             $model->update();
    //         }

    //     });
    // }
}
