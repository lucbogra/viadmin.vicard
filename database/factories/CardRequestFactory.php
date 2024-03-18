<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardRequest>
 */
class CardRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = uniqid();

        return [
            'status'  => 'validated',
            'receips' => [
                "uid"  => uniqid(),
                "file" => "https://vicards.s3.eu-central-1.amazonaws.com/files/u_abcdedghijk/transaction-receips/65f59e0520ed1_1710595589.png",
                "name" => "Receipt_$number.png"
            ]
        ];
    }
}
