<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPurchaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->unsignedInteger('provider_id')->index()->nullable();
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->string('delivery')->nullable();
            $table->enum('method_of_payment', ['efectivo', 'tarjeta','transferencia', 'cheque', 'pago online', 'consignacion'])->default('efectivo');
            $table->enum('way_of_payment', ['contado', 'credito'])->default('contado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('provider_id');
            $table->dropColumn('delivery');
            $table->dropColumn('method_of_payment');
        });
    }
}
