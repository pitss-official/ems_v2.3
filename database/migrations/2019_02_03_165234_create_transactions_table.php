<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('receiver');
            $table->unsignedInteger('sender');
            $table->string('description', 150);
            $table->boolean('wasQueued')->default(0);
            $table->float('amount', 16, 4);
            $table->unsignedTinyInteger('visibility')->default(1);
            $table->unsignedInteger('initBy');
            $table->unsignedInteger('queueID')->nullable()->default('');
            $table->foreign('queueID')->references('id')->on('queues');
            $table->foreign('sender')->references('collegeUID')->on('accounts');
            $table->foreign('receiver')->references('collegeUID')->on('accounts');
            $table->foreign('initBy')->references('collegeUID')->on('users');
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
        Schema::dropIfExists('transactions');
    }
}
