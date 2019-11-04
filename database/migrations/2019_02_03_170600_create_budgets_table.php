<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name');
            $table->double('value');
            $table->double('remainingValue');
            $table->boolean('parent')->default(false);
            $table->unsignedBigInteger('parentID')->nullable();
            $table->unsignedBigInteger('eventID');
            $table->unsignedInteger('createdBy');
            $table->unsignedBigInteger('account');
            $table->foreign('account')->references('number')->on('accounts');
            $table->foreign('eventID')->references('id')->on('events');
            $table->foreign('createdBy')->references('collegeUID')->on('users');
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
        Schema::dropIfExists('budgets');
    }
}
