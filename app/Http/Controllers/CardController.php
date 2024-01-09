<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Card;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Objects\FilterObject;
use App\Services\ImageService;
use App\Models\CardTopUpRequest;
use App\Http\Resources\BankResource;
use App\Http\Resources\CardResource;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\CardTopUpRequestResource;

class CardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate("cards.index");

        $filter = new FilterObject;
        
        $cards = CardResource::collection(
            Card::when($filter->status, function($query) use ($filter) {
                    $query->status($filter->status);
                })
                ->when($filter->term, function($query) use ($filter) {
                    $query->search($filter->term);
                })
                ->with('owner')
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );

        return Inertia::render("Cards/Index", compact("cards", "breadcrumbs", "filter"));

    }
    

}
