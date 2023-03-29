<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSessionToConsumed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumed', function (Blueprint $table) {
            $table->integer('session')->after('amount');
            $table->integer('sessions')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumed', function (Blueprint $table) {
            $table->dropColumn('session');
            $table->dropColumn('sessions');
        });
    }
}
