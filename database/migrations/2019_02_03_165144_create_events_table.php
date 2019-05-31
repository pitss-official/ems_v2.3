<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name', 150);
            $table->unsignedInteger('requesterID');
            $table->unsignedInteger('approvalID')->default(0);
            $table->unsignedInteger('ticketPrice');
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->unsignedInteger('seats');
            //is this a team event
            $table->boolean('teaming')->default(0);

            $table->float('maxIncentiveRate', 5, 2);

            //supportContacts
            $table->string('supportMail')->nullable();
            $table->unsignedBigInteger('supportMobile')->nullable();
            $table->unsignedBigInteger('altSupportMobile')->nullable();

            //for the cases where user can pay partialy to reserve his or her seats in the event
            $table->unsignedTinyInteger('minimumPayment')->default(100);

            $table->boolean('approvalStatus')->default(0);
            $table->date('approvalDate')->nullable();

            //This varibale is true when the event proposal is submitted in the DSA
            $table->unsignedTinyInteger('fillingStatus')->default(0);
            /*
             *enrollmentMinimumPowerRequiremnet
             *Like all members can enroll or just coordinators can enroll
             *Varies from 0-1024
             * 0==ALL Can enroll
            */
            $table->unsignedSmallInteger('minimumUserPower')->default(0);
            //is event availbale for enrollment
            $table->boolean('visibility')->default(1);
            $table->unsignedInteger('filledSeats')->default(0);

            //REFRENECNING
            $table->foreign('requesterID')->references('collegeUID')->on('users');
            $table->foreign('approvalID')->references('collegeUID')->on('users');
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
        Schema::dropIfExists('events');
    }
}
