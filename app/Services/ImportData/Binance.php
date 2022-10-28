<?php

namespace App\Services\ImportData;

use App\Components\ImportDataClient;
use App\Contracts\ImportData\NetworkPrice;
use App\MarketPrice;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use http\Env\Request;
use http\Exception;
use Illuminate\Support\Facades\Log;

class Binance implements NetworkPrice
{
    protected $endpoint;
    protected $dataClient;

    public $prices = [];
    public $coinPairs = [

    ];

    public function __construct()
    {
        $this->endpoint = config('services.binance.endpoint');
        $this->dataClient = new ImportDataClient($this->endpoint);
        $this->setPrices();
    }

    public function setPrices()
    {
        try {
            $local_prices = $this->getLocalPrices();
            if ($local_prices->count() == 0 || $local_prices->first()->updated_at->diffInMinutes(now('UTC')) > 1) {
                $prices = $this->loadPrices();
                $this->prices = $this->savePrices($prices);
                Log::info('Coins price updated: '.now('UTC'));
            } else {
                $this->prices = $local_prices;
            }
        } catch (\Exception $exception) {
            $this->prices = $this->getLocalPrices();
            Log::error('Load API error: '.$exception->getMessage());
        }
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

    public function getLocalPrices()
    {
        return MarketPrice::all()->unique()->sortBy('id');
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

        return $this->prices = $this->getLocalPrices();
    }

}
