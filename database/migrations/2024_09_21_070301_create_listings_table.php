<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_new')->default(false);
            // $table->string('title', 255);
            $table->bigInteger('price');
            $table->integer('quantity')->unsigned();
            $table->integer('moq')->unsigned();
            $table->string('serial_number')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('status_id')->nullable()->constrained('statuses');
            $table->timestamp('status_changed_at')->useCurrent();
        });

        Schema::create('category_listing', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('listing_id')->nullable()->constrained('listings');

            $table->primary(['category_id', 'listing_id']);
            $table->unique(['category_id', 'listing_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_listing');
        Schema::dropIfExists('listings');
    }
}
