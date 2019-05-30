<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('number');
            $table->string('name');
            $table->unsignedInteger('collegeUID');
            $table->float('balance', 20, 4);
            $table->boolean('onHold')->default(0);
            $table->unsignedInteger('createdBy')->default(0);
            $table->unsignedSmallInteger('type')->default(0);
            $table->unsignedInteger('queueID')->default(0);
            $table->timestamps();
            $table->foreign('collegeUID')->references('collegeUID')->on('users')->onDelete('cascade');
            $table->foreign('createdBy')->references('collegeUID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
