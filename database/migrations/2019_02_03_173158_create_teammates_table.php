<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeammatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('teammates', function (Blueprint $table) {
//            $table->unsignedBigInteger('id')->autoIncrement();
//            $table->unsignedBigInteger('teamID');
//            $table->unsignedInteger('collegeUID');
//            $table->foreign('collegeUID')->references('collegeUID')->on('users');
//            //$table->foreign('teamID')->references('id')->on('teams');
//            $table->timestamps();
//      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teammates');
    }
}
