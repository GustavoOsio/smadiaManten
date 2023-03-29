<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleHistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_historial', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('schedule_id')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->nullable();
            $table->string('professional')->nullable();
            $table->string('contract')->nullable();
            $table->string('service')->nullable();
            $table->longText('comment')->nullable();
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->longText('comment_update')->nullable();
            $table->string('date_update')->nullable();
            $table->string('user')->nullable();
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
        Schema::dropIfExists('schedule_historial');
    }
}
