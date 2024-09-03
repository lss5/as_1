<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturersTable extends Migration
{
    public function up()
    {
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->integer('sort')->unsigned()->default(10);
        });
    }

    public function down()
    {
        Schema::dropIfExists('manufacturers');
    }
}
