<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes_comisiones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('income_id')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('seller_id')->nullable();
            $table->decimal('amount', 19, 2)->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('center_cost_id')->nullable();
            $table->string('form_pay', 100)->nullable();
            $table->string('contract', 100)->nullable();
            $table->string('date', 100)->nullable();
            $table->string('pay_card', 10)->default('no')->nullable();
            $table->decimal('totally', 19, 2);
            $table->decimal('commission', 19, 2);
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
        Schema::dropIfExists('incomes_comisiones');
    }
}
