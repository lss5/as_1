<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportDataClient
{
    public $client;
    public $endpoint;

    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;

        $this->client = new Client([
            'base_uri' => $this->endpoint,
            'timeout'  => 2.0,
//            'verify' => false,
        ]);
    }
}
