<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->index()->after('provider_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('cellar_id')->index()->after('provider_id');
            $table->foreign('cellar_id')->references('id')->on('cellars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('cellar_id');
        });
    }
}
