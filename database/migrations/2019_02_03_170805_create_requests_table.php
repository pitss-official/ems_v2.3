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
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('requesterCollegeUID');
            $table->unsignedInteger('approverCollegeUID');
            $table->unsignedSmallInteger('type');
            $table->unsignedSmallInteger('levelRequired');
            $table->text('requestReason');
            $table->string('approvalRemarks');
            $table->unsignedBigInteger('transactionID')->nullable();
            $table->unsignedBigInteger('queueID')->nullable();
            $table->timestamps();
        });
        Schema::table('requests',function ($table){
//        $table->foreign('queueID')->references('id')->on('queues');
        $table->foreign('requesterCollegeUID')->references('collegeUID')->on('users');
        $table->foreign('approverCollegeUID')->references('collegeUID')->on('users');
        $table->foreign('transactionID')->references('id')->on('transactions');});
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
