<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlinePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('MID',40);
            $table->string('TXNID',128)->unique();
            $table->string('ORDERID',100);
            $table->string('BANKTXNID',255)->nullable();
            $table->string('TXNAMOUNT',20);
            $table->string('CURRENCY',10);
            $table->string('STATUS',40);
            $table->string('RESPCODE',20);
            $table->string('RESPMSG',1024);
            $table->dateTime('TXNDATE');
            $table->string('GATEWAYNAME',30);
            $table->string('BANKNAME',1024)->nullable();
            $table->string('PAYMENTMODE',30);
            /*
             * Payment Modes
             * Credit card – CC
             * Debit card - DC
             * Net banking - NB
             * UPI - UPI
             * Paytm wallet – PPI
             * Postpaid - PAYTMCC
             */
            $table->string('CHECKSUMHASH',255);
            $table->string('BIN_NUMBER',10)->nullable();
            $table->string('CARD_LAST_NUMS',25)->nullable();
            $table->boolean('verified')->default(false);
            $table->text('request');
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
        Schema::dropIfExists('online_payments');
    }
}
