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
            'card_counts' => $this->whenCounted('cards'),
            'notifs' => $this->notifs(),
            'role' => $this->roles->first(),
            'created_at' => (new AppService)->dateFormatter($this->created_at),
            'updated_at' => (new AppService)->dateFormatter($this->updated_at),
        ];
    }

    private function notifs() {
        $reqCounts = $this->cardRequests()->where('status', 'pending')->count();
        $topupReqCounts = $this->cardTopUpRequests()->where('status', 'pending')->count();
        
        return [
            "card_requests_count" => $reqCounts,
            "card_topup_requests_count" => $topupReqCounts,
            "total_notifs" => $reqCounts + $topupReqCounts
        ];
    }
}
