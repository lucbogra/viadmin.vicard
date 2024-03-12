<?php

namespace App\Models\CodInvestor;

use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use HasFactory;

    protected $connection = 'coddb';

    protected $table = 'users';

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function vicardUser() : HasOne
    {
        return $this->hasOne(ModelsUser::class, 'cod_investor_id');
    }

}
