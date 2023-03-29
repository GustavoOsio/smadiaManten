<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreToBiologicalMedicinePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biological_medicine_plan', function (Blueprint $table) {
            $table->longText('array_observations')->after('array_biological_medicine');
            $table->integer('cicle')->after('array_observations');
            $table->integer('sesion')->after('cicle');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biological_medicine_plan', function (Blueprint $table) {
            $table->dropColumn('cicle');
            $table->dropColumn('sesion');
        });
    }
}
