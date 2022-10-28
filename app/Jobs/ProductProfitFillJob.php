<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;
use App\Services\ImportData\WhatToMine;

class ProductProfitFillJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        if (!empty($this->product->hashrate)) {
            $wtm = new WhatToMine();
            $profit = $wtm->getProfit($this->product);

            if (empty($profit)) {
                return false;
            }

            $this->product->mining_time = 24;
            $this->product->btc_revenue = preg_replace('/[^0-9\.,]/','', $profit->btc_revenue);
            $this->product->revenue = preg_replace('/[^0-9\.,]/','', $profit->revenue);
            $this->product->mining_timestamp = Carbon::createFromTimestamp($profit->timestamp);
            $this->product->mining_direction = false;

            $this->product->save();
        }
    }
}
