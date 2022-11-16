<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusProductTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->char('status', 36)->default('created');
            $table->timestamp('status_changed_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('status_changed_at');
        });
    }
}
