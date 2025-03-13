<?php

use Cmgmyr\Messenger\Models\Models;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    public function up()
    {
        Schema::create(Models::table('threads'), function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('type', 36)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Models::table('threads'));
    }
}
