<?php

namespace App\Http\Resources;

use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'owner_name' => $this->owner_name,
            'bank_name' => $this->bank_name,
            'address' => $this->address,
            'iban' => $this->iban,
            'meta' => $this->meta,
            'created_at' => (new AppService)->dateFormatter($this->created_at),
            'updated_at' => (new AppService)->dateFormatter($this->updated_at),
        ];
    }
}
