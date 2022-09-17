<?php

namespace App\Contracts\ImportData;

interface NetworkPrice
{
    public function loadPrices();
    public function setPrices();
    public function getLocalPrices();
    public function savePrices(array $price);
}
