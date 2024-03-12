<?php

namespace App\Http\Controllers\CodInvestor;

use App\Http\Controllers\Controller;
use App\Models\CodInvestor\User;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function index()
    {
        // return User::has('vicardUser')->get();

        return User::join('vicard_db.users as vicardusers', 'users.id', '=', 'vicardusers.cod_investor_id')
            ->join('codinvestorsdb.investors as affiliates', 'users.id', '=', 'affiliates.user_id')
            ->select(['vicardusers.name', 'affiliates.wallet'])
            ->get();
    }
}
