<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\User;
use App\Models\Invoice;
use App\Models\CardRequest;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            MerchantSeeder::class
        ]);

        // User::factory(10)->create()->each(function ($customer, $customerKey) {

        //     $customer->assignRole('Account Owner');

        //     $createdAt = Carbon::today()->subDays(rand(0, 100));

        //     CardRequest::factory(random_int(3, 12))->create([
        //         // 'user_id' => User::admins()->first()?->id,
        //         'user_id' => $customer->id,
        //         'created_at' => $createdAt,
        //     ])
        //     ->each(function ($cardRequest, $cardRequestKey)  use ($customer, $createdAt) {

        //         $cardCreatedAt = Carbon::today()->subDays(rand(0, 100));

        //         Card::factory()->create([
        //             'card_validity' => $cardCreatedAt->copy()->addYears(random_int(1, 3)),
        //             'owner_id' => $customer->id,
        //             'card_request_id' => $cardRequest->id,
        //             // 'date'       => $createdAt,
        //             'created_at' => $cardCreatedAt,
        //             'updated_at' => $cardCreatedAt,
        //         ])
        //         ->each(function ($card, $cardKey)  use ($customer, $cardRequest) {

        //             // $isFirstCard = $customer->cards->count() == 0;

        //             // $period = $card->created_at;
        //             // $limit  = 99999;
        //             // $invoiceCount = Invoice::count() + 1;

        //             // if ($invoiceCount > $limit) {
        //             //     $invoiceCount = $invoiceCount - $limit;
        //             // }

        //             // $invoiceNumber = "INV";
        //             // $invoiceNumber .= $period->format('ym');
        //             // $invoiceNumber .= Str::padLeft(($invoiceCount), strlen($limit), '0');

        //             // Invoice::factory()->create([
        //             //     "invoice_number" => $invoiceNumber,
        //             //     "customer_id"    => $customer->id,
        //             //     "period"         => $card->created_at->format("Y-m"),
        //             //     "card_id"        => $card->id,
        //             //     "amount"         => $isFirstCard ? config('billing.first_card_cost') : config('billing.other_cards_cost'),
        //             //     "receips"        => $cardRequest->receips,
        //             //     "paid_at"        => $card->created_at,
        //             //     "created_at"     => $card->created_at,
        //             //     "updated_at"     => $card->updated_at
        //             // ]);

        //         });


        //     });

        //     $customer->cards()->attach(Card::where('owner_id', $customer->id)->get()->pluck('id')->toArray(), attributes: [
        //         'owner' => true,
        //         'permissions' => json_encode(['all'])
        //     ]);

        // });
    }
}
