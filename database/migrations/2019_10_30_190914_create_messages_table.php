<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sender');
            $table->text('message');
            $table->timestamp('read_time')->nullable();
            $table->unsignedTinyInteger('device')->default(0);
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('chats');
            $table->foreign('sender')->references('collegeUID')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
