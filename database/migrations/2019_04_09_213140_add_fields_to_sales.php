<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('type_of_card', ['debito', 'mastercard', 'visa', 'american express', 'dinners club'])->nullable();
            $table->string('approved_of_card', 30)->nullable();
            $table->string('card_entity', 40)->nullable();
            $table->string('receipt', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('type_of_card');
            $table->dropColumn('approved_of_card');
            $table->dropColumn('card_entity');
            $table->dropColumn('receipt');
        });
    }
}
