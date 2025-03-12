<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    protected $fillable = [
        'symbol',
        'priceChange',
        'priceChangePercent',
        'weightedAvgPrice',
        'openPrice',
        'highPrice',
        'lowPrice',
        'lastPrice',
        'volume',
        'quoteVolume',
    ];
}
