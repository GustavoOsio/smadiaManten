<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectronicEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electronic_equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 60);
            $table->string("number", 30);
            $table->string("brand", 60);
            $table->string("model", 30);
            $table->string("serial", 30);
            $table->string("voltage", 30);
            $table->string("location", 120);
            $table->integer('equips_active')->default(-1);
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
        Schema::dropIfExists('electronic_equipments');
    }
}
