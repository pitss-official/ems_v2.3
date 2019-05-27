<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smartcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('secretID_A', '10');
            $table->string('secretID_B', '10');
            $table->string('secretID_C', '10');
            $table->string('secretID_D', '10');
            $table->string('secretID_E', '10');
            $table->unique(['secretID_A', 'secretID_B', 'secretID_C', 'secretID_D', 'secretID_E']);
            $table->boolean('touched')->default(false);
            $table->boolean('used')->default(false);
            $table->dateTime('redeemTimeStamp')->nullable();
            $table->integer('studentCollegeUID')->nullable();
            $table->foreign('studentCollegeUID')->references('collegeUID')->on('users');
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
        Schema::dropIfExists('smartcards');
    }
}
