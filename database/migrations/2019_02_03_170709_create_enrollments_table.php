<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('eventID');
            $table->unsignedInteger('participantCollegeUID');
            $table->unsignedInteger('facilitatorCollegeUID');
            $table->unsignedBigInteger('fundTransactionID')->nullable();
            $table->unsignedBigInteger('enrollmentFeesTransactionID');
            $table->boolean('partialPay')->default(0);

            $table->foreign('eventID')->references('id')->on('events');
            $table->foreign('participantCollegeUID')->references('collegeUID')->on('users');
            $table->foreign('facilitatorCollegeUID')->references('collegeUID')->on('users');
            $table->foreign('fundTransactionID')->references('id')->on('transactions');
            $table->foreign('enrollmentFeesTransactionID')->references('id')->on('transactions');

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
        Schema::dropIfExists('enrollments');
    }
}
