<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentAssistanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_assistance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id');
            $table->string('patient');
            $table->string('identi');
            $table->string('asyst');
            $table->string('serv');
            $table->string('sesion');
            $table->string('date');
            $table->string('contract');
            $table->integer('price');
            $table->integer('desc');
            $table->integer('comision');
            $table->string('seller');
            $table->string('stable_status');
            $table->integer('total');
            $table->integer('balance_favor');
            $table->string('pay')->default('no');
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
        Schema::dropIfExists('payment_assistance');
    }
}
