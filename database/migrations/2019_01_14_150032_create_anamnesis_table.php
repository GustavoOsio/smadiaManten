<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnamnesisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anamnesis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->longText('reason_consultation');
            $table->longText('current_illness');
            $table->longText('ant_patologico');
            $table->longText('ant_surgical');
            $table->longText('ant_allergic');
            $table->longText('ant_traumatic');
            $table->longText('ant_medicines');
            $table->longText('ant_gynecological');
            $table->longText('ant_fum')->nullable();
            $table->longText('ant_habits');
            $table->longText('ant_familiar');
            $table->longText('ant_nutritional');
            $table->longText('observations');
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
        Schema::dropIfExists('anamnesis');
    }
}
