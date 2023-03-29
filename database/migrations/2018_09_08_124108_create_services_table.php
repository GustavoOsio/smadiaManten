<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('price');
            $table->string('price_pay')->nullable();
            $table->string('price_input')->nullable();
            $table->string('percent')->nullable();
            $table->string('xpenses_sheet')->nullable();
            $table->string('equipment_id')->nullable();
            $table->enum('restricted', ['SI', 'NO'])->default('SI');
            $table->enum('contract', ['SI', 'NO'])->default('SI');
            $table->enum('status', ['activo', 'inactivo'])->default('activo');
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
        Schema::dropIfExists('services');
    }
}
