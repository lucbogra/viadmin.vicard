<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Notifications\CardBilingNotification;

class BillCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bill:cards {arg?}';

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
        $arg = $this->argument('arg') ?? null;

        $accountOnwers = User::accountOwners()
                                ->whereHas('cards')
                                ->with(['cards'])
                                ->get();

        foreach ($accountOnwers as $key => $owner) {

            $format = "Y-m";

            if ($arg == "lm") {

                $period = today()->subMonth();

            } else {

                $period = today();

            }

            $orderNumber = Str::padLeft(random_int(0, 9999), 4, 0);

            $invoice = [
                "invoice_number" => "INV{$period->format('ym')}$orderNumber",
                "customer_id"  => $owner->id,
                "period"       => $period->format($format),
                "currency"     => "USD",
                "amount"       => 0,
                "billed_cards" => [],
                "paid_at"      => null
            ];

            $billedCards = [];

            foreach ($owner->cards as $key => $card) {
                
                $billedCards[] = [
                    'card_id'     => $card->id,
                    'card_number' => $card->card_number,
                    'amount'      => $key == 0 
                                        ? config('billing.first_card_cost') 
                                        : config('billing.other_cards_cost'),
                ];

            }

            // $invoice['billed_cards'] = collect($billedCards);
            $invoice['billed_cards'] = $billedCards;
            $invoice['amount'] = array_sum(array_column($billedCards, 'amount'));

            if (!$owner->invoices()->where("period", $period->format($format))->first()) {

                // info($invoice);
                $newInvoice = $owner->invoices()->create($invoice);

                $owner->notify(new CardBilingNotification(invoice: $newInvoice, period: $period));

            }

            // $this->info(collect($invoice));
            // $this->newLine();

            info("Billing completed");

        }
    }
}
