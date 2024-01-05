<?php

namespace App\Http\Resources;

use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'notifs' => $this->notifs(),
            'role' => $this->roles->first(),
            'created_at' => (new AppService)->dateFormatter($this->created_at),
            'updated_at' => (new AppService)->dateFormatter($this->updated_at),
        ];
    }

    private function notifs() {
        return [
            "card_requests_count" => $this->cardRequests()->where('status', 'pending')->count(),
            "card_topup_requests_count" => $this->cardTopUpRequests()->where('status', 'pending')->count()
        ];
    }
}
