<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvolutionsToInfirmaryEvolutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infirmary_evolution', function (Blueprint $table) {
            $table->longText('array_evolutions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('infirmary_evolution', function (Blueprint $table) {
            $table->dropColumn('array_evolutions');
        });
    }
}
