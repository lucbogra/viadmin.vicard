<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [20000, 25000, 10000, 15000, 30000];
        $cardLimit = $data[random_int(0, 4)];

        return [
            // 'owner_id' => $cardRequest->user_id,
            // 'card_request_id' => $cardRequest->id,
            'nickname' => $this->faker->unique()->userName(),
            'card_number' => $this->faker->creditCardNumber(),
            'card_limit' => $cardLimit,
            'card_balance' => 0,
            'card_fees' => 0,
            'daily_limit' => $cardLimit,
            'per_transaction_limit' => $cardLimit,
            'card_status' => 'activated',
            'card_type' => ['virtual', 'physical'][random_int(0, 1)],
        ];
    }
}
