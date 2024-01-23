<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\CardRequest;
use Illuminate\Http\Request;
use App\Objects\FilterObject;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Http\Resources\CardRequestResource;
use App\Http\Resources\CardTopUpRequestResource;
use App\Models\CardTopUpRequest;

class RequestController extends Controller
{
    public function cardRequests()
    {       
        $breadcrumbs = Breadcrumbs::generate("card-requests.index");
        
        auth()->user()->unreadNotifications()->where('type', 'App\Notifications\CardRequestNotification')->update(['read_at' => now()]);

        $filter = new FilterObject;

        $cardRequests = CardRequestResource::collection(
                CardRequest::when($filter->status, function($query) use ($filter) {
                        $query->status($filter->status);
                    })
                    ->with(['user'])
                    ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                    ->paginate($filter->perPage)
                    ->withQueryString()
            );

        return Inertia::render("CardRequests/Index", compact("cardRequests", "filter", "breadcrumbs"));
    }

        /**
     * Display a listing of the resource.
     */
    public function topupRequests ()
    {
        $breadcrumbs = Breadcrumbs::generate("topup-requests.index");
        
        $filter = new FilterObject;

        $cardTopupRequests = CardTopUpRequestResource::collection(
            CardTopUpRequest::when($filter->status, function($query) use ($filter) {
                    $query->status($filter->status);
                })
                ->with(['user', 'transaction', 'card' => ['owner']])
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );

        return Inertia::render("CardTopupRequests/Index", compact("cardTopupRequests", "filter", "breadcrumbs"));
    }
}
