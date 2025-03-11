<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlgorithmProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('algorithm_product', function (Blueprint $table) {
            $table->foreignId('algorithm_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->primary(['algorithm_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('algorithm_product');
    }
}
