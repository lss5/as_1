<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')->constrained();
            $table->bigInteger('country_id')->unsigned();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->bigInteger('price');
            $table->Integer('quantity')->unsigned();
            $table->Integer('moq')->unsigned();
            $table->Integer('views')->unsigned()->default(0);
            $table->Integer('power')->nullable();
            $table->Integer('hashrate')->nullable();
            $table->String('hashrate_name')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('isnew')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
