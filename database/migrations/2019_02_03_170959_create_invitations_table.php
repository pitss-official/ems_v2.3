<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('intendedUID');
            $table->unsignedBigInteger('eventID');
            $table->unsignedInteger('invitedBy');
            $table->foreign('intendedUID')->references('collegeUID')->on('users');
            $table->foreign('eventID')->references('id')->on('events');
            $table->foreign('invitedBy')->references('collegeUID')->on('users');
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
        Schema::dropIfExists('invitations');
    }
}
