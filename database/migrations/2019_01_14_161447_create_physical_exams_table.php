<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhysicalExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->string('weight');
            $table->string('height');
            $table->string('imc');
            $table->longText('head_neck');
            $table->longText('cardiopulmonary');
            $table->longText('abdomen');
            $table->longText('extremities');
            $table->longText('nervous_system');
            $table->longText('skin_fanera');
            $table->longText('others')->nullable();
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
        Schema::dropIfExists('physical_exams');
    }
}
