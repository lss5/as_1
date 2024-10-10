<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('algorithm_id')->constrained();
            $table->integer('coin_id');
            $table->string('coin_name');
            $table->string('coin_tag');
            $table->unsignedBigInteger('btc_revenue');
            $table->BigInteger('cost');
            $table->timestamp('updated_time')->nullable();
            $table->integer('mining_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profits');
    }
}