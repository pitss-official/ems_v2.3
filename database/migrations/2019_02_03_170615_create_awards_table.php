<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('eventID');
            $table->unsignedInteger('collegeUID')->nullable();
            $table->unsignedInteger('itemID')->nullable();
            $table->unsignedInteger('teamID')->nullable();
            //$table->foreign('itemID')->references('id')->on('stock_items');
            $table->foreign('eventID')->references('id')->on('events');
//            $table->foreign('teamID')->references('id')->on('teams');
            $table->string('title', 100);
            $table->timestamps();
            $table->foreign('collegeUID')->references('collegeUID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('awards');
    }
}
