<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToInccomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->string('ref_epayco', 30)->nullable();
            $table->string('approved_epayco', 30)->nullable();
            $table->enum('method_of_pay_2', ['efectivo', 'tarjeta', 'consignacion', 'tarjeta recargable', 'software', 'online','tranferencia','unificacion','white','bono'])->nullable();
            $table->enum('type_of_card_2', ['debito', 'mastercard', 'visa', 'american express', 'dinners club'])->nullable();
            $table->string('approved_of_card_2', 30)->nullable();
            $table->string('card_entity_2', 40)->nullable();
            $table->string('origin_bank_2', 40)->nullable();
            $table->string('origin_account_2', 40)->nullable();
            $table->string('ref_epayco_2', 30)->nullable();
            $table->string('approved_epayco_2', 30)->nullable();
            $table->string('receipt')->nullable();
            $table->string('receipt_2')->nullable();
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
            $table->dropColumn('ref_epayco');
            $table->dropColumn('approved_epayco');
            $table->dropColumn('method_of_pay_2');
            $table->dropColumn('type_of_card_2');
            $table->dropColumn('approved_of_card_2');
            $table->dropColumn('card_entity_2');
            $table->dropColumn('origin_bank_2');
            $table->dropColumn('origin_account_2');
            $table->dropColumn('ref_epayco_2');
            $table->dropColumn('approved_epayco_2');
            $table->dropColumn('receipt');
            $table->dropColumn('receipt_2');
        });
    }
}
