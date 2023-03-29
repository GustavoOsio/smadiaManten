<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiagnosisToRelationLaboratoryExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relation_laboratory_exams', function (Blueprint $table) {
            $table->string('diagnosis')->after('laboratory_exams_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relation_laboratory_exams', function (Blueprint $table) {
            $table->dropColumn('diagnosis');
        });
    }
}
