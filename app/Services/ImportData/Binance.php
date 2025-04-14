<?php

namespace App\Services\ImportData;

use App\Components\ImportDataClient;
use App\Contracts\ImportData\NetworkPrice;
use App\Jobs\ExchangeRateUpdateJob;
use App\Models\MarketPrice;
use Illuminate\Support\Facades\Log;

class Binance implements NetworkPrice
{
    public ImportDataClient $dataClient;

    public function __construct()
    {
        $this->dataClient = new ImportDataClient(config('services.binance.endpoint'));
    }

    public function getPrices()
    {
        $prices = MarketPrice::all()->unique()->sortBy('id');

        if ($prices->count() == 0 || $prices->first()->updated_at->diffInMinutes(now('UTC')) > 10) {
            ExchangeRateUpdateJob::dispatch();
        }

        return $prices;
    }

    public function loadPrices(): array
    {
        $response = $this->dataClient->client->request('GET', 'ticker', [
            'query' => [
                'symbols' => '["BTCUSDT","ETHUSDT","XMRUSDT","ETCUSDT","LTCUSDT","DOGEUSDT"]',
                'windowSize' => '23h',
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), null);
        }

        Log::error('API Response code: '.$response->getStatusCode());

        return [];
    }

    public function savePrices(array $prices)
    {
        foreach ($prices as $item) {
            MarketPrice::updateOrCreate([
                'symbol' => $item->symbol,
            ],[
                'symbol' => $item->symbol,
                'priceChange' => $item->priceChange,
                'priceChangePercent' => $item->priceChangePercent,
                'weightedAvgPrice' => $item->weightedAvgPrice,
                'openPrice' => $item->openPrice,
                'highPrice' => $item->highPrice,
                'lowPrice' => $item->lowPrice,
                'lastPrice' => $item->lastPrice,
                'volume' => $item->volume,
                'quoteVolume' => $item->quoteVolume,
            ]);
        }
    }

}
