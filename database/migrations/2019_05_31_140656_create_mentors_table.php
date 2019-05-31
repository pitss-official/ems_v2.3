<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('groupID');
            $table->unsignedInteger('memberID');
            $table->foreign('memberID')->references('collegeUID')->on('users');
            $table->unsignedBigInteger('eventID');
            $table->foreign('eventID')->references('id')->on('events');
            $table->unsignedSmallInteger('memberType')->default(0);
            $table->unsignedBigInteger('dayID');
            $table->foreign('dayID')->references('id')->on('eventdates');
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
        Schema::dropIfExists('mentors');
    }
}
