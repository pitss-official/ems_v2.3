<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNavigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_navigation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('menu_id');
            $table->string('menu_name',255);
            $table->string('icon',255);
            $table->unsignedBigInteger('parent_id');
            $table->string('link',255);
            $table->unsignedTinyInteger('status');
            $table->string('title',255);
            $table->unsignedInteger('level');
            $table->unsignedInteger('jump_id');
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
        Schema::dropIfExists('user_navigation');
    }
}
