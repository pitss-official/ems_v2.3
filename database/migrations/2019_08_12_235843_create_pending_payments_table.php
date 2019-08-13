<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('collegeUID');
            $table->string('transactionID',1024);
            $table->boolean('approval')->default(false);
            $table->timestamp('approvalTime')->nullable();
            $table->unsignedDecimal('amount');
            $table->unsignedBigInteger('debitAccountNumber');
            $table->unsignedBigInteger('creditAccountNumber');
            $table->string('reference',1024)->nullable();
            $table->string('remarks',1024)->nullable();
            $table->foreign('collegeUID')->references('collegeUID')->on('users');
            $table->foreign('debitAccountNumber')->references('number')->on('accounts');
            $table->foreign('creditAccountNumber')->references('number')->on('accounts');
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
        Schema::dropIfExists('pending_payments');
    }
}
