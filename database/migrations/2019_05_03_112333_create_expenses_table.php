<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('provider_id')->index()->nullable();
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->text('date');
            $table->unsignedInteger('purchase_orders_id')->index()->nullable();
            $table->foreign('purchase_orders_id')->references('id')->on('purchases');
            $table->string('form_pay'); // forma de pago
            $table->string('value'); // valor de egreso
            $table->string('iva'); // valor del iva
            $table->unsignedInteger('center_costs_id')->index()->nullable();
            $table->foreign('center_costs_id')->references('id')->on('center_costs');
            $table->unsignedInteger('retention_id')->index()->nullable();
            $table->foreign('retention_id')->references('id')->on('retention');
            $table->string('total_expense'); //total del egreso
            /*nuevas*/
            $table->longText('observations')->nullable();
            $table->string('porcent_iva'); // porcentaje del iva
            $table->string('apli_fact'); // aplica factura si o no
            $table->string('desc_pront_pay'); // Desc. por Pronto Pago si o no
            $table->string('desc_type'); // tipo de descuento % (porcentaje) o $ (dinero)
            $table->string('desc_value'); // valor del descuento
            $table->string('desc_total'); // total del descuento
            $table->string('rte_aplica'); // aplica retencion si o no
            $table->string('rte_value'); // valor a retener
            $table->string('rte_base'); // base de retencion
            $table->string('rte_porcent'); // porcentaje de retencion

            $table->string('rte_iva'); // retencion iva si o no
            $table->string('rte_iva_porcent'); // retencion iva porcentaje
            $table->string('rte_iva_value'); // retencion iva valor
            $table->string('rte_ica'); // retencion ica si o no
            $table->string('rte_ica_porcent'); // retencion ica porcentaje
            $table->string('rte_ica_value'); // retencion ica valor
            $table->string('rte_cree'); // retencion cree si o no
            $table->string('rte_cree_porcent'); // retencion cree porcentaje
            $table->string('rte_cree_value'); // retencion cree valor
            /*end nuevas*/
            $table->string('status')->default('activo'); // activo o anulado
            $table->longText('motivo');
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
        Schema::dropIfExists('expenses');
    }
}
