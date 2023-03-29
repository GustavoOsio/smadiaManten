<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->string('imc');
            $table->string('weight');
            $table->string('bust');
            $table->string('contour');
            $table->string('waistline');
            $table->string('umbilical');
            $table->string('abd_lower');
            $table->string('abd_higher');
            $table->string('hip');
            $table->string('legs');
            $table->string('right_thigh');
            $table->string('left_thigh');
            $table->string('right_arm');
            $table->string('left_arm');
            $table->longText('observations')->nullable();
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
        Schema::dropIfExists('measurements');
    }
}
