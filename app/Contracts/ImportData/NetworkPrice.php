<?php

namespace App\Contracts\ImportData;

interface NetworkPrice
{
    public function getPrices();

    public function loadPrices();
    public function savePrices(array $price);
}
