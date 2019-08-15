<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            //id as queue id
            $table->unsignedBigInteger('id')->autoIncrement();

            //remarks by the requester who is putting task into queue
            $table->string('requesterRemarks', 200)->nullable();
            //parameters
            $table->text('parameters')->nullable();
            //remarks by the approver at the time of authorizing the action
            $table->string('approveTimeRemarks', 200)->nullable();
            //requester UID
            $table->unsignedInteger('requestedBy');

            //approver UID
            $table->unsignedInteger('approvedBy')->default(0);

            //Level of the action as Severity parameter
            $table->unsignedSmallInteger('authenticationLevel');

            //Type of the action like 21 for balance transfer
            $table->unsignedSmallInteger('type');
            $table->string('typeMessage',150)->nullable();

            //Status of the action weather approved or not
            $table->boolean('isApproved')->default(0);

            //if specific person is required to approve specific queue
            $table->unsignedInteger('specificApproval')->default(0)->nullable();

            //is the queue visible to the user
            $table->boolean('visibility')->default(1);

            //aproval time of the queue
            $table->dateTime('approvalTime')->nullable();
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
        Schema::dropIfExists('queues');
    }
}
