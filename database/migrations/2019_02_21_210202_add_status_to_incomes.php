<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToIncomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->text('campaign')->nullable()->after('type');
            $table->enum('status', ['activo', 'anulado'])->default('activo')->after('campaign');
            $table->longText('motivo')->nullable()->after('status');
            $table->longText('unification')->nullable();
            $table->longText('unification_2')->nullable();
            $table->unsignedInteger('follow_id')->default(1)->nullable();
            $table->foreign('follow_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
