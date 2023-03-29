<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedInteger('contract_id')->nullable();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->unsignedInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->unsignedInteger('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('users');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('center_cost_id');
            $table->foreign('center_cost_id')->references('id')->on('center_costs');
            $table->unsignedInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->unsignedInteger('account2_id')->nullable();
            $table->foreign('account2_id')->references('id')->on('accounts');
            $table->decimal('amount', 19, 2);
            $table->text('comment');
            $table->enum('method_of_pay', ['efectivo', 'tarjeta', 'consignacion', 'tarjeta recargable', 'software', 'online','tranferencia','unificacion','white','bono'])->default('efectivo');
            //actualizacion en ambos method_of_pay NOTA URGENTE!!!!!!!!!
            $table->enum('type', ['unico', 'compartido', 'bolsa']);
            $table->enum('type_of_card', ['debito', 'mastercard', 'visa', 'american express', 'dinners club'])->nullable();
            $table->string('approved_of_card', 30)->nullable();
            $table->string('card_entity', 40)->nullable();
            $table->string('origin_bank', 40)->nullable();
            $table->string('origin_account', 40)->nullable();
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
        Schema::dropIfExists('incomes');
    }
}
