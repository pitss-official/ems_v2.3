<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstName',50);
            $table->string('middleName',50)->nullable();
            $table->string('lastName',50)->nullable();
            $table->string('fathersName',150)->nullable();
            $table->unsignedBigInteger('createdBy')->default(0);
            $table->unsignedSmallInteger('gender')->default(0);
            $table->date('birthday')->nullable();
            $table->string('nationality',3)->default('IN');
            $table->string('bloodGroup',5)->nullable();
            $table->dateTime('lastLogin')->useCurrent();
            $table->float('incentiveRate',10,2)->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->bigInteger('mobile');
            $table->bigInteger('altMobile')->nullable();
            $table->unsignedSmallInteger('authorityLevel')->default(0);
            $table->text('address')->nullable();
            $table->unsignedInteger('collegeUID')->unique();
            $table->unsignedInteger('referenceUID')->nullable()->default(0);
            $table->unsignedSmallInteger('theme')->default(0);
            //
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
