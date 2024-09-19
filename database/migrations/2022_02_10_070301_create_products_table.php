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
            $table->boolean('isnew')->default(false);
            $table->timestamp('active_at')->nullable();
            $table->Integer('mining_time')->unsigned()->default(0);
            $table->float('btc_revenue', 20, 8)->nullable();
            $table->float('revenue', 20, 4)->nullable();
            $table->datetime('mining_timestamp', 0)->nullable();
            $table->boolean('mining_direction')->default(0);
            $table->char('status', 36)->default('created');
            $table->timestamp('status_changed_at')->useCurrent();
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
