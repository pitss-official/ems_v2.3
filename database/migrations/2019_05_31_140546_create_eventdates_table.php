<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventdates', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->date('date');
            $table->string('motive',100);
            $table->text('description')->nullable();
            $table->time('startTime');
            $table->time('endTime');
            $table->unsignedInteger('coordinatorsRequired')->default(1);
            $table->unsignedBigInteger('eventID');
            $table->timestamps();
            $table->foreign('eventID')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventdates');
    }
}
