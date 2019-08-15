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
            $table->string('MID');
            $table->string( 'TXNID');
            $table->string('ORDERID');
            $table->string('BANKTXNID')->nullable();
            $table->string('TXNAMOUNT');
            $table->string('CURRENCY');
            $table->string('STATUS');
            $table->string('RESPCODE');
            $table->string('RESPMSG');
            $table->string('TXNGATE');
            $table->string('GATEWAYNAME');
            $table->string('BANKNAME');
            $table->string('PAYMENTMODE');
            $table->string('CHECKSUMHASH');
            $table->string('BIN_NUMBER');
            $table->string('CARD_LAST_NUMs');
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
