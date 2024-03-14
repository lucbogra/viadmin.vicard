<?php

namespace App\Http\Resources;

use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardRequestResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'card' => new CardResource($this->whenLoaded('card')),
            'status' => [
                'key' => $this->status,
                'label' => $this->getStatus($this->status)
            ],
            'receips' => $this->receips,
            'created_at' => (new AppService)->dateFormatter($this->created_at),
            'updated_at' => (new AppService)->dateFormatter($this->updated_at),
        ];
    }

    public function getStatus($status) {

        if ($status == 'cancelled') {
            
            return __('Cancelled');

        }

        if ($status == 'validated') {
            
            return __('Validated');

        }

        return __('Pending');

    }
}
