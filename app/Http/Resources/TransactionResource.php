<?php

namespace App\Http\Resources;

use App\Services\AppService;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'card' => new CardResource($this->whenLoaded('card')),
            'user' => new UserResource($this->whenLoaded('user')),
            'merchant' => $this->whenLoaded('merchant'),
            'type' => $this->type,
            'method' => $this->method,
            'merchant' => $this->merchant,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'receips' => $this->receips,
            'confirmed' => $this->confirmed,
            'date' => (new AppService)->dateFormatter($this->date),
            'created_at' => (new AppService)->dateFormatter($this->created_at),
            'updated_at' => (new AppService)->dateFormatter($this->updated_at),
        ];
    }

}
