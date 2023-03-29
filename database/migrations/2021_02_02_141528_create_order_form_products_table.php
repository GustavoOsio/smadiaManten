<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderFormProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_form_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_form_id');
            //$table->foreign('order_form_id')->references('id')->on('order_form');
            $table->unsignedInteger('product_id');
            //$table->foreign('product_id')->references('id')->on('products');
            $table->decimal('qty', 10,2);
            $table->decimal('price', 19, 2);
            $table->decimal('tax', 19, 2);

            //recepcion
            $table->decimal('qty_fal', 10,2)->nullable();
            $table->string('lote')->nullable();
            $table->string('expiration')->nullable();
            $table->string('invima')->nullable();
            $table->string('date_invima')->nullable();
            $table->string('renov_invima',10)->nullable();

            $table->string('packing',10)->nullable();
            $table->string('transport',10)->nullable();
            $table->string('inconfirmness',10)->nullable();
            $table->string('temperature',10)->nullable();
            $table->string('accepted',10)->nullable();
            $table->enum('status', ['new','fault', 'complet','older','new_2','fault_2']);
            $table->unsignedInteger('order_receipt_id')->nullable();
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
        Schema::dropIfExists('order_form_products');
    }
}
