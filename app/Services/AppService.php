<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Support\Str;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\NotificationResource;

class AppService {

    public function randomString(int $stringLength = 12, bool $all = true) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $numeric = '1234567890';
        $specialCars = '';

        $all = "";

        $all .= $alphabet;
        
        if ($all) {
            $all .= $numeric;
            $all .= $specialCars;
        }

        $string = array();
        $alphaLength = strlen($all) - 1;

        for ($i = 0; $i < $stringLength; $i++) {
            $n = rand(0, $alphaLength);
            $string[] = random_int(0, 1) ? $all[$n] : Str::upper($all[$n]);
        }

        return implode($string);
    }

    public function generateNumber(int $stringLength = 10) {
        $numbers = '1234567890';

        $string = array();

        $alphaLength = strlen($numbers) - 1;

        for ($i = 0; $i < $stringLength; $i++) {
            $n = rand(0, $alphaLength);
            $string[] = random_int(0, 1) ? $numbers[$n] : Str::upper($numbers[$n]);
        }

        return implode($string);
    }

    public function formatMoney(float|int $amount = null, $nullEqualToZoro = false): array|null
    {
        if ($amount == null) {

            if (!$nullEqualToZoro) {
                return null;
            }

            $amount = 0;
        }

        $formatted = number_format($amount, 2, '.', ',');

        return [
            "original"         => $amount,
            "without_currency" => $formatted,
            "with_currency"    => $formatted,
        ];

    }

    public static function dateFormatter(Carbon $date = null, bool $expirable = false) {
        return [
            "original"  => $date,
            "formatted" => $date?->format("d/m/Y"),
            "with_time" => $date?->format("d/m/Y H:i"),
            "dif_for_humans" => $date?->diffForHumans(),
            "month" => $date?->format("m/y"),
            "db" => [
                "short" => $date?->format("Y-m-d"),
                "full" => $date?->format("Y-m-d H:i:s"),
            ]
        ];
    }

    public static function notifications(bool $unReads = false) {

        if ($unReads) {
            
            return NotificationResource::collection(auth()->user()->unreadNotifications);
            
        }

        return NotificationResource::collection(auth()->user()->notifications);
    }

    public static function unPaidInvoices() {

        return InvoiceResource::collection(Invoice::unPaids()->get());

    }

}