<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPurchaseConnectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_purchase_connection', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_purchase_id')->index();
            $table->foreign('order_purchase_id')->references('id')->on('purchase_orders');
            $table->unsignedInteger('order_form_id')->index();
            $table->foreign('order_form_id')->references('id')->on('order_form');
            $table->unsignedInteger('product_id')->index();
            $table->foreign('product_id')->references('id')->on('order_products');
            $table->unsignedInteger('order_form_p_id')->index();
            $table->foreign('order_form_p_id')->references('id')->on('order_form_products');
            $table->decimal('order_rest', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_purchase_connection');
    }
}
