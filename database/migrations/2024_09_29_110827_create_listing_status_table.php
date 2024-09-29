<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_status', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('listing_id')->nullable()->constrained('listings');
            $table->foreignId('status_id')->nullable()->constrained('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('listings', function (Blueprint $table) {
        //     $table->dropForeign('listings_listing_id_foreign');
        //     $table->dropColumn('listing_id');
        // });
        Schema::dropIfExists('listing_status');
    }
}
