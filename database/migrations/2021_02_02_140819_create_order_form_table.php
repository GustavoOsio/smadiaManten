<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_form', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); //quien crea
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('receive_id'); //quien recibe
            $table->foreign('receive_id')->references('id')->on('users');
            $table->unsignedInteger('provider_id')->index()->nullable(); //provedor
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->string('delivery')->nullable(); //lugar de entrega

            $table->unsignedInteger('cellar_id')->index(); //bodega
            $table->foreign('cellar_id')->references('id')->on('cellars');

            $table->string('bill')->nullable(); //factura
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

            $table->enum('status', ['creada','realizada', 'recibida','anulada','cerrada']);
            $table->text('comment');
            $table->text('motivo');
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
        Schema::dropIfExists('order_form');
    }
}
