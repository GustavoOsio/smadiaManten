<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('seller_id')->index();
            $table->foreign('seller_id')->references('id')->on('users');
            $table->decimal('amount', 19, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->enum('type_discount', ['price', 'percent'])->nullable();
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->integer('qty_products');
            $table->enum('method_payment', ['efectivo', 'credito', 'cheque', 'consignacion', 'tarjeta', 'transferencia','online']);
            $table->enum('method_payment_2', ['efectivo', 'credito', 'cheque', 'consignacion', 'tarjeta', 'transferencia','online'])->nullable();
            $table->decimal('total_1', 19, 2)->nullable();
            $table->decimal('total_2', 19, 2)->nullable();
            $table->string('number_account', 20)->nullable();
            $table->string('number_account_2', 20)->nullable();
            $table->string('approval_number', 20)->nullable();
            $table->string('approval_number_2', 20)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
