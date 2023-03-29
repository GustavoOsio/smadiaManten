<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('status', ['activo', 'anulada'])->after('approval_number_2')->default('activo');
            $table->decimal('sub_amount', 19, 2)->after('seller_id');
            $table->longText('observations')->nullable();
            $table->longText('comments')->nullable();

            $table->enum('type_of_card_2', ['debito', 'mastercard', 'visa', 'american express', 'dinners club'])->nullable();
            $table->string('approved_of_card_2', 30)->nullable();
            $table->string('card_entity_2', 40)->nullable();
            $table->string('receipt_2', 255)->nullable();

            $table->string('partner_discount', 10)->default('no')->nullable();

            $table->string('ref_epayco', 30)->nullable();
            $table->string('approved_epayco', 30)->nullable();
            $table->string('ref_epayco_2', 30)->nullable();
            $table->string('approved_epayco_2', 30)->nullable();
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
            $table->dropColumn('status');
        });
    }
}
