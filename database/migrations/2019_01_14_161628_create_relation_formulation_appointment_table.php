<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationFormulationAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_formulation_appointment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formulation_appointment_id')->index('formulation_appointment_index')->nullable();
            $table->foreign('formulation_appointment_id', 'formulation_appointment_id_foreign')->references('id')->on('formulation_appointment');
            $table->string('formula')->nullable();
            $table->string('other')->nullable();
            $table->string('another_formula')->nullable();
            $table->string('indications')->nullable();
            $table->longText('formulation')->nullable();
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
        Schema::dropIfExists('relation_formulation_appointment');
    }
}
