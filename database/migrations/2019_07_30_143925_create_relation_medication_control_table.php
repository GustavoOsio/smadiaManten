<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationMedicationControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_medication_control', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('medication_control_id')->index()->nullable();
            $table->foreign('medication_control_id')->references('id')->on('medication_control');
            $table->string('medicine');
            $table->string('date');
            $table->string('hour');
            $table->string('initial');
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
        Schema::dropIfExists('relation_medication_control');
    }
}
