<?php

namespace App\Console\Commands;

use App\Models\AutoNumber;
use App\Models\Card;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Notifications\CardBilingNotification;
use Carbon\Carbon;

class BillCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bill:cards {day?} {month?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command allows you to create invoices for valid cards';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $day    = $this->argument('day') ?? date('d');
        $month  = $this->argument('month') ?? date('m');
        $endDay = $day;
        $date   = Carbon::parse(date("Y-$month-$day"));
    
        if ($date->copy()->addDay()->format('d') == '01') {
            $endDay = 31;
        }

        $cards = Card::status('activated')
                    ->whereDay('created_at', '>=', $day)
                    ->whereDay('created_at', '<=', $endDay)
                    // ->whereDate('created_at', '!=', today())
                    ->with(['owner' => [
                        'cards' => function($query) {
                            $query->status('activated');
                        }
                    ]])
                    ->get();

        // $this->createNumberingIfNot();

        $bar = $this->output->createProgressBar(count($cards));

        $bar->start();

        $billedCardCount = 0;

        foreach ($cards as $key => $card) {

            $index = $card->owner->cards->search(function ($item) use ($card) {
                return $item->id === $card->id;
            });

            $period = $card->created_at;
            $format = "Y-" . Str::padLeft($month, 2, 0);

            $invoice = [
                "customer_id"  => $card->owner->id,
                "period"       => $period->format($format),
                "currency"     => config('currency.invoice_currency'),
                "amount"       => 0,
                "card_id"      => $card->id,
                "paid_at"      => null
            ];

            if ($index !== false) {
                $rang = $index + 1;

                if ($rang === 1) {
                    $invoice["amount"] = config('billing.first_card_cost');
                } else {
                    $invoice["amount"] = config('billing.other_cards_cost');
                }

                // $message = "La carte $card->card_number se trouve au rang $rang/{$card->owner->cards->count()} dans la collection.";
            } else {

                continue;
            }

            if (!$card->owner->invoices()->where("period", $period->format($format))->where("card_id", $card->id)->first()) {

                $newInvoice = $card->owner->invoices()->create($invoice);

                $billedCardCount++;

                $card->owner->notify(new CardBilingNotification(invoice: $newInvoice, card: $card, period: $period));

            }

            $bar->advance();

        }

        $bar->finish();

        $this->newLine();
        $this->info("Billing completed successfully. " . ($billedCardCount . "/" . count($cards)) . " have been billed.");

    }

    public function createNumberingIfNot(string $key = 'invoice') {
        AutoNumber::updateOrCreate(['key' => $key], [
            'current_number' => 1,
            'max_length' => 5
        ]);
    }

    // public function handle()
    // {
    //     $arg = $this->argument('arg') ?? null;

    //     $accountOnwers = User::accountOwners()
    //                             ->whereHas('cards')
    //                             ->with(['cards' => function($query) {
    //                                 $query->status('activated');
    //                             }])
    //                             ->get();

    //     $bar = $this->output->createProgressBar(count($accountOnwers));

    //     $bar->start();

    //     $billedAccountCount = 0;

    //     foreach ($accountOnwers as $key => $owner) {

    //         $format = "Y-m";

    //         if ($arg == "lm") {

    //             $period = today()->subMonth();

    //         } else {

    //             $period = today();

    //         }

    //         $orderNumber = Str::padLeft(random_int(0, 9999), 4, 0);

    //         $invoice = [
    //             "invoice_number" => "INV{$period->format('ym')}$orderNumber",
    //             "customer_id"  => $owner->id,
    //             "period"       => $period->format($format),
    //             "currency"     => "USD",
    //             "amount"       => 0,
    //             "billed_cards" => [],
    //             "paid_at"      => null
    //         ];

    //         $billedCards = [];

    //         foreach ($owner->cards as $key => $card) {

    //             $billedCards[] = [
    //                 'card_id'     => $card->id,
    //                 'card_number' => $card->card_number,
    //                 'amount'      => $key == 0
    //                                     ? config('billing.first_card_cost')
    //                                     : config('billing.other_cards_cost'),
    //             ];

    //         }

    //         $invoice['billed_cards'] = $billedCards;
    //         $invoice['amount'] = array_sum(array_column($billedCards, 'amount'));

    //         if (!$owner->invoices()->where("period", $period->format($format))->first()) {

    //             $newInvoice = $owner->invoices()->create($invoice);

    //             $billedAccountCount++;

    //             $owner->notify(new CardBilingNotification(invoice: $newInvoice, period: $period));

    //         }

    //         $bar->advance();

    //     }

    //     $bar->finish();

    //     $this->newLine();
    //     $this->info("Billing completed successfully. " . ($billedAccountCount . "/" . count($accountOnwers)) . " have been billed.");

    // }
}
