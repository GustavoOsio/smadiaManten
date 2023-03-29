<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurgicalDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surgical_description', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->string('diagnosis');
            $table->longText('preoperative_diagnosis');
            $table->longText('postoperative_diagnosis');
            $table->string('surgeon');
            $table->string('anesthesiologist');
            $table->string('assistant');
            $table->string('surgical_instrument');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('code_cups')->nullable();
            $table->string('intervention');
            $table->string('control_compresas')->nullable();
            $table->string('type_anesthesia');
            $table->longText('description_findings');
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
        Schema::dropIfExists('surgical_description');
    }
}
