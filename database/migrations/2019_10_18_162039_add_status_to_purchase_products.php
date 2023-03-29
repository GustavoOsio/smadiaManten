<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToPurchaseProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->longText('missing')->nullable();
            $table->longText('full_amount')->nullable();
            $table->enum('inventory',['si','no'])->default('no')->nullable();
            $table->decimal('qty_inventory', 65,0)->default(0);
            $table->decimal('qty_inventory_personal', 65,0)->default(0);
            $table->unsignedInteger('inventory_personal_id')->index();
            $table->foreign('inventory_personal_id')->references('id')->on('users');

            $table->decimal('qty_inventory_ever', 65,0)->default(0);
            $table->decimal('qty_inventory_personal_ever', 65,0)->default(0);
            $table->longText('observations_ajust')->nullable();
        });
    }

    /**162034
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->dropColumn(['missing']);
            $table->dropColumn('full_amount');
            $table->dropColumn('inventory');
            $table->dropColumn('qty_inventory_personal');
            $table->dropColumn('inventory_personal_id');
        });
    }
}
