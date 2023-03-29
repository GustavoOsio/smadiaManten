<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationTreatmentPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_treatment_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tratment_plan_id')->index()->nullable();
            $table->foreign('tratment_plan_id')->references('id')->on('treatment_plan');
            $table->string('service_line');
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
        Schema::dropIfExists('relation_treatment_plan');
    }
}
