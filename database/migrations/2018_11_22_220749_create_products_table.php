<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('reference', 30);
            $table->decimal('tax', 4, 2);
            $table->decimal('price', 15, 2);
            $table->decimal('stock', 10, 2);
            $table->unsignedInteger('presentation_id');
            $table->foreign('presentation_id')->references('id')->on('types');
            $table->unsignedInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('types');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('types');
            $table->unsignedInteger('inventory_id');
            $table->foreign('inventory_id')->references('id')->on('types');
            //$table->unsignedInteger('provider_id');
            //$table->foreign('provider_id')->references('id')->on('providers');
            $table->string('form',5)->default('activo');
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
        Schema::dropIfExists('products');
    }
}
