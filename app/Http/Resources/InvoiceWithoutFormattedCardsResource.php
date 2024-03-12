<?php

namespace App\Http\Resources;

use App\Models\Card;
use App\Services\AppService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceWithoutFormattedCardsResource extends JsonResource
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
            'period' => [
                'original'  => $this->period,
                'formatted' => Carbon::parse("{$this->period}-01")->format("M, Y")
            ],
            'invoice_number' => $this->invoice_number,
            'amount' => $this->amount,
            'billed_cards' => $this->billed_cards,
            'customer' => new CustomerResource($this->whenLoaded("customer")),
            'paid_at' => (new AppService)->dateFormatter($this->paid_at),
            'created_at' => (new AppService)->dateFormatter($this->created_at),
            'updated_at' => (new AppService)->dateFormatter($this->updated_at),
        ];
    }

}
