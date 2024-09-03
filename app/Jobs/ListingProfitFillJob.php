<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use App\Services\ImportData\WhatToMine;

class ListingProfitFillJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $listing;

    public function __construct($listing)
    {
        $this->listing = $listing;
    }

    public function handle()
    {
        $wtm = new WhatToMine();
        switch ($this->listing->algorithm) {
            case 'sha256':
                $profit = $wtm->getProfit($this->listing, '1.json');
                break;

            case 'scrypt':
                $profit = $wtm->getProfit($this->listing, '6.json');
                break;

            default:
                break;
        }
        Log::info('ListingProfitFillJob - '.$this->listing->algorithm);

        if (empty($profit)) {
            return false;
        }

        $this->listing->mining_time = 24;
        $this->listing->btc_revenue = preg_replace('/[^0-9\.,]/','', $profit->btc_revenue);
        $this->listing->revenue = preg_replace('/[^0-9\.,]/','', $profit->revenue);
        $this->listing->mining_timestamp = Carbon::createFromTimestamp($profit->timestamp);
        $this->listing->mining_direction = false;
        $this->listing->save();

        return true;
    }
}
