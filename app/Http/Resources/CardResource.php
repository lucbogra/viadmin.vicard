<?php

namespace App\Http\Resources;

use Brick\Money\Money;
use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'owner' => new UserResource($this->whenLoaded('owner')),
            'nickname' => $this->nickname,
            'card_number' => $this->card_number,
            'card_limit' => $this->card_limit,
            'card_type' => $this->card_type,
            'card_balance' => $this->card_balance,
            'card_status' => $this->card_status,
            'daily_limit' => $this->daily_limit,
            'per_transaction_limit' => $this->per_transaction_limit,
            'card_fees' => $this->card_fees,
            'total_transactions' => $this->totalTransactions(),
            'card_validity' => (new AppService)->dateFormatter($this->card_validity),
            'created_at' => (new AppService)->dateFormatter($this->created_at),
            'updated_at' => (new AppService)->dateFormatter($this->updated_at),
        ];
    }

    public function totalTransactions(): array
    {
        return [
            'deposit'  => Money::ofMinor($this->transactions()->where('type', 'deposit')->sum('amount'), config('currency.currency')),
            'withdraw' => Money::ofMinor($this->transactions()->where('type', 'withdraw')->sum('amount'), config('currency.currency')),
        ];
    }
}
