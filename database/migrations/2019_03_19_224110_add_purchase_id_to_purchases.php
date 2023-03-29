<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchaseIdToPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->dropForeign('purchase_products_purchase_order_id_foreign');
            $table->dropColumn('purchase_order_id');
            $table->unsignedInteger('purchase_id')->index()->after('id');
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->unsignedInteger('cellar_id')->index()->after('id');
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
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->unsignedInteger('purchase_order_id')->index();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->dropColumn('purchase_id');
            $table->dropColumn('cellar_id');
        });
    }
}
