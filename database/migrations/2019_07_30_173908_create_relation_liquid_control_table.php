<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationLiquidControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_liquid_control', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('liquid_control_id')->index()->nullable();
            $table->foreign('liquid_control_id')->references('id')->on('liquid_control');
            $table->string('hour');
            $table->string('type');
            $table->string('type_element');
            $table->string('box');
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
        Schema::dropIfExists('relation_liquid_control');
    }
}
