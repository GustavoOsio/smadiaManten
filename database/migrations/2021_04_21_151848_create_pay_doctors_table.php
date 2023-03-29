<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('assistant_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->integer('schedule_id');
            $table->string('patient');
            $table->string('identification');
            $table->string('assistant',250)->nullable();
            $table->string('service',250)->nullable();
            $table->string('session');
            $table->string('date');
            $table->string('contract');
            $table->integer('price');
            $table->integer('discount');
            //pagos
            $table->string('pay_card', 10)->default('no')->nullable();
            $table->integer('card');
            $table->integer('deducible');
            $table->integer('totally');
            $table->integer('commission');
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
        Schema::dropIfExists('pay_doctors');
    }
}
