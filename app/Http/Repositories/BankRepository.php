<?php

namespace App\Http\Repositories;

use App\Models\Bank;
use App\Objects\FilterObject;
use App\Http\Resources\BankResource;

class BankRepository {
    
    public function all(FilterObject $filter) {

        return BankResource::collection(
            Bank::when($filter->term, function($query) use ($filter) {
                    $query->search($filter->term);
                })
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );
       
    }
    
    // public function show(User $customer) {
        
    //     return new CustomerResource($customer);
       
    // }
    
}