<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->string('bill', 20)->nullable();
            $table->decimal('total', 20, 2);
            $table->decimal('discount', 15, 2);
            $table->enum('payment_method', ['efectivo', 'tarjeta','transferencia', 'cheque', 'pago online', 'consignacion'])->default('efectivo');
            $table->enum('way_of_pay', ['contado', 'credito'])->default('contado');
            $table->integer('days')->nullable();
            $table->date('expiration')->nullable();
            $table->unsignedInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('bank', 50)->nullable();
            $table->string('account', 20)->nullable();
            $table->unsignedInteger('center_cost_id');
            $table->foreign('center_cost_id')->references('id')->on('center_costs');
            $table->text('comment');
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
        Schema::dropIfExists('purchases');
    }
}
