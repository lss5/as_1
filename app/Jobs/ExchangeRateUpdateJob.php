<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Contracts\ImportData\NetworkPrice;
use Illuminate\Support\Facades\Log;

class ExchangeRateUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(NetworkPrice $networkPrice)
    {
        try {
            $prices = $networkPrice->loadPrices();
            $networkPrice->savePrices($prices);

            Log::info('ExchangeRateUpdateJob - Coins price updated: '.now('UTC'));
        } catch (\Exception $exception) {
            Log::error('ExchangeRateUpdateJob - Load API error: '.$exception->getMessage());
        }
    }

}
