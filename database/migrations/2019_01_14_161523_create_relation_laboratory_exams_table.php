<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationLaboratoryExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_laboratory_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('laboratory_exams_id')->index()->nullable();
            $table->foreign('laboratory_exams_id')->references('id')->on('laboratory_exams');
            $table->string('exam');
            $table->string('other_exam')->nullable();
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
        Schema::dropIfExists('relation_laboratory_exams');
    }
}
