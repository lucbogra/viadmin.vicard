<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Models\CardRequest;
use App\Objects\FilterObject;
use App\Http\Resources\CardResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CardRequestResource;
use App\Http\Resources\CardTopUpRequestResource;

class CustomerRepository {
    

    public function all(FilterObject $filter) {
        
        return CustomerResource::collection(
            User::customers()
                ->when($filter->term, function($query) use ($filter) {
                        $query->search($filter->term);
                })
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );
       
    }

    public function allCards(User $customer, FilterObject $filter) {
  
        return CardResource::collection(
            $customer->cards()
                ->when($filter->status, function($query) use ($filter) {
                    $query->status($filter->status);
                })
                ->with('owner')
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );
       
    }

    public function allCardRequests(User $customer, FilterObject $filter) {
        
        return CardRequestResource::collection(
            $customer->cardRequests()
                ->when($filter->status, function($query) use ($filter) {
                    $query->status($filter->status);
                })
                ->with(['user'])
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );
       
    }

    public function allCardTopupRequests(User $customer, FilterObject $filter) {
        
        return CardTopUpRequestResource::collection(
            $customer->cardTopUpRequests()
                ->when($filter->status, function($query) use ($filter) {
                    $query->status($filter->status);
                })
                ->with(['user', 'transaction', 'card' => ['owner']])
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );
       
    }
    
    public function show(User $customer) {
        
        $customer = $customer->load(['cardRequests', 'cardTopUpRequests', 'owner']);

        return new CustomerResource($customer);
       
    }
    
}