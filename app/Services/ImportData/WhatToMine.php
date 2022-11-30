<?php

namespace App\Services\ImportData;

use Illuminate\Support\Facades\Log;
use App\Components\ImportDataClient;
use App\Product;

class WhatToMine
{
    protected $endpoint;
    protected $dataClient;

    public $prices = [];
    public $coinPairs = [

    ];

    public function __construct()
    {
        $this->endpoint = config('services.whattomine.endpoint');
        $this->dataClient = new ImportDataClient($this->endpoint);
    }

    public function getProfitBTC(Product $product)
    {
        try {
            $response = $this->dataClient->client->request('GET', '1.json', [
                'query' => [
                    'hr' => $product->hashrate,
                    'p' => '0',
                    'cost' => '0',
                    'cost_currency' => 'USD',
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
}