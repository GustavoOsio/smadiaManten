<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_comisiones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sale_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('sales_product_id')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('seller_id')->nullable();
            $table->decimal('amount', 19, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->string('form_pay', 100)->nullable();
            $table->decimal('commission', 19, 2);
            $table->string('status', 10)->default('activa')->nullable();
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
        Schema::dropIfExists('sales_comisiones');
    }
}
