<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('registeredBy');
            $table->unsignedInteger('type')->default(1);
            //block address
            $table->string('primaryAddressLine', 100);
            $table->string('name', 100);
            $table->string('secondaryAddressLine', 100)->nullable();
            $table->string('tertiaryAddressLine', 100)->nullable();
            $table->string('shortAddress', 60);
            $table->unsignedInteger('coordinatorsRequired')->default(1);
            $table->unsignedInteger('capacity');
            $table->float('price', 10, 2)->default(0);
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
        Schema::dropIfExists('venues');
    }
}
