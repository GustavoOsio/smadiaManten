<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationClinicalDiagnosticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_clinical_diagnostics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clinical_diagnostics_id')->index()->nullable();
            $table->foreign('clinical_diagnostics_id')->references('id')->on('clinical_diagnostics');
            $table->string('diagnosis');
            $table->enum('type',['principal','relacionado'])->default('principal')->nullable();
            $table->string('external_cause')->nullable();
            $table->string('treatment_plan')->nullable();
            $table->string('other')->nullable();
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
        Schema::dropIfExists('relation_clinical_diagnostics');
    }
}
