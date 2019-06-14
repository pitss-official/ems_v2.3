<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smartcards', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('sIDA', '10');
            $table->string('sIDB', '10');
            $table->string('sIDC', '10');
            $table->string('sIDD', '10');
            $table->string('sIDE', '10');
            $table->boolean('isActive')->default(false);
            $table->bigInteger('eventID');
            $table->foreign('eventID')->references('id')->on('events');
            $table->unique(['sIDA', 'sIDB', 'sIDC', 'sIDD', 'sIDE']);
            $table->boolean('touched')->default(false);
            $table->boolean('used')->default(false);
            $table->dateTime('redeemTimeStamp')->nullable();
            $table->unsignedInteger('studentCollegeUID')->nullable();
            $table->foreign('studentCollegeUID')->references('collegeUID')->on('users');
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
        Schema::dropIfExists('smartcards');
    }
}
