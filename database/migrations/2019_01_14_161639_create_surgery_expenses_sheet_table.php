<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurgeryExpensesSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surgery_expenses_sheet', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->string('date_of_surgery');
            $table->string('room');
            $table->string('weight');
            $table->string('type_patient');
            $table->string('type_anesthesia');
            $table->string('type_surgery');
            $table->string('surgery');
            $table->string('surgery_code');
            $table->string('time_entry');
            $table->string('start_time_surgery');
            $table->string('end_time_surgery');
            $table->string('surgeon');
            $table->string('assistant');
            $table->string('anesthesiologist');
            $table->string('rotary');
            $table->string('instrument');
            //$table->string('array_products');
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
        Schema::dropIfExists('surgery_expenses_sheet');
    }
}
