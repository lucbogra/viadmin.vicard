<?php

namespace App\Http\Resources;

use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardTopUpRequestResource extends JsonResource
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
            'attachments' => $this->attachments,
            'status' => [
                'key' => $this->status,
                'label' => $this->getStatus($this->status)
            ],
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
