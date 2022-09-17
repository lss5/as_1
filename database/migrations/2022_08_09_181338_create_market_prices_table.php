<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketPricesTable extends Migration
{
    public function up()
    {
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->string('symbol'); // "BTCUSDT"
            $table->float('priceChange', 20,8); // "-104.25000000"
            $table->float('priceChangePercent', 20,8); // "-0.517"
            $table->float('weightedAvgPrice', 20,8); // "20060.92792991"
            $table->float('openPrice', 20,8); // "20167.08000000"
            $table->float('highPrice', 20,8); // "20279.61000000"
            $table->float('lowPrice', 20,8); // "19800.00000000"
            $table->float('lastPrice', 20,8); // "20062.83000000"
            $table->float('volume', 20,8); // "136026.33697000"
            $table->float('quoteVolume', 20,8); // "2728814542.52419900"

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('market_prices');
    }
}
