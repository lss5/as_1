<?php

namespace App\Services\ImportData;

use App\Components\ImportDataClient;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class WhatToMine
{
    protected $endpoint;
    protected $dataClient;

    public function __construct()
    {
        $this->endpoint = config('services.whattomine.endpoint');
        $this->dataClient = new ImportDataClient($this->endpoint);
    }

    public function getProfit(Product $product, $uri)
    {
        try {
            $response = $this->dataClient->client->request('GET', 'coins/'.$uri.'.json', [
                'query' => [
                    'hr' => $product->hashrate,
                    'p' => '0',
                    'fee' => '0',
                    'cost' => '0',
                    'cost_currency' => 'USD',
                    'hcost' => '0',
                    'span_br' => '24',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), null);
            }

        } catch (\Throwable $exception) {
            Log::error('WTM API error for ProductID:'.$product->id.', Error: '.$exception->getMessage());
            return [];
        }
    }

    public function getCoins($algorithm)
    {
        try {
            $response = $this->dataClient->client->request('GET', 'asic.json', [
                'query' => [
                    $algorithm => 'true',
                    'factor[cost]' => '0.1',
                    'factor[cost_currency]' => 'USD',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), null);
            }

        } catch (\Throwable $exception) {
            Log::error('WhatToMine:getCoins('.$algorithm.'), Error: '.$exception->getMessage());
            return [];
        }
    }
}
