<?php

namespace App\Models\CodInvestor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $connection = 'coddb';

    protected $table = 'sellers';

}
