<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('requesterCollegeUID');
            $table->unsignedInteger('approverCollegeUID');
            $table->unsignedSmallInteger('type');
            $table->unsignedSmallInteger('levelRequired');
            $table->text('requestReason');
            $table->string('approvalRemarks');
            $table->integer('transactionID')->nullable();
            $table->integer('queueID')->nullable();
            $table->foreign('queueID')->references('id')->on('queues');
            $table->foreign('requesterCollegeUID')->references('collegeUID')->on('users');
            $table->foreign('approverCollegeUID')->references('collegeUID')->on('users');
            $table->foreign('transactionID')->references('id')->on('transactions');
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
        Schema::dropIfExists('requests');
    }
}
