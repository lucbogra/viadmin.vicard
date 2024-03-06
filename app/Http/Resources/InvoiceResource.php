<?php

namespace App\Http\Resources;

use App\Models\Card;
use App\Services\AppService;
use Brick\Money\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'billed_cards' => $this->buildBilledCards($this->billed_cards),
            'id' => $this->id,
            'period' => [
                'original'  => $this->period,
                'formatted' => Carbon::parse("{$this->period}-01")->format("M, Y")
            ],
            'invoice_number' => $this->invoice_number,
            'amount' => $this->amount,
            'customer' => new CustomerResource($this->whenLoaded("customer")),
            'paid_at' => (new AppService)->dateFormatter($this->paid_at),
            'created_at' => (new AppService)->dateFormatter($this->created_at),
            'updated_at' => (new AppService)->dateFormatter($this->updated_at),
        ];
    }

    public function buildBilledCards(array $billedCards): array
    {
        $cards = [];

        for ($i=0; $i < count($billedCards ?? []); $i++) { 
            
            $billedCard = $billedCards[$i];

            $card = Card::where("id", data_get($billedCard, 'card_id'))->withTrashed()->first();

            if ($card) {
                
                $cards[] = [
                    "card_number" => $card->card_number,
                    "amount" => Money::of(data_get($billedCard, 'amount'), 'USD')
                ];

            }
        }

        return $cards;
    }
}
