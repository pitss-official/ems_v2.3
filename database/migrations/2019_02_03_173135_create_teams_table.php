<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name');
            $table->unsignedTinyInteger('maxCapacity')->default(2);
            $table->unsignedTinyInteger('availedCapacity')->default(0);
            $table->unsignedBigInteger('eventID');
            $table->text('description')->nullable();
            $table->unique(['eventID','name']);
            $table->foreign('eventID')->references('id')->on('events');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
