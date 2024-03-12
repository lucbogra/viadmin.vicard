<?php

namespace App\Models\CodInvestor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $connection = 'coddb';

    protected $table = 'investors';

}
