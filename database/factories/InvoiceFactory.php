<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $period = today();

        $format = "Y-m";

        return [
            // "customer_id"  => $card->owner->id,
            // "period"       => $period->format($format),
            // "card_id"      => $card->id,
            // "amount"       => $isFirstCard ? config('billing.first_card_cost') : config('billing.other_cards_cost'),
            // "receips"        => $cardRequest->receips,
            // "paid_at"        => $cardRequest->created_at
            "currency"     => "USD",
            "payment_method" => "Bank Transfer",
            "status"         => "paid",
        ];

    }
}
