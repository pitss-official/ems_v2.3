<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('dateID');
            $table->unsignedInteger('attendeeUID');
            $table->unsignedInteger('coordinatorUID');
            $table->unsignedBigInteger('enrollmentID');
            $table->foreign('enrollmentID')->references('id')->on('enrollments');
            $table->foreign('coordinatorUID')->references('collegeUID')->on('users');
            $table->foreign('attendeeUID')->references('collegeUID')->on('users');
            $table->foreign('dateID')->references('id')->on('eventdates');
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
        Schema::dropIfExists('attendence');
    }
}
