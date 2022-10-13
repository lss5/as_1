<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfitToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->Integer('mining_time')->unsigned()->default(0);
            $table->float('btc_revenue', 20, 8)->nullable();
            $table->float('revenue', 20, 4)->nullable();
            $table->datetime('mining_timestamp', 0)->nullable();
            $table->boolean('mining_direction')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('mining_time');
            $table->dropColumn('btc_revenue');
            $table->dropColumn('revenue');
            $table->dropColumn('mining_timestamp');
            $table->dropColumn('mining_direction');
        });
    }
}
