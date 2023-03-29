<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_review', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->longText('system_head_face_neck')->nullable();
            $table->longText('system_respiratory_cardio')->nullable();
            $table->longText('system_digestive')->nullable();
            $table->longText('system_genito_urinary')->nullable();
            $table->longText('system_locomotor')->nullable();
            $table->longText('system_nervous')->nullable();
            $table->longText('system_integumentary')->nullable();
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
        Schema::dropIfExists('system_review');
    }
}
