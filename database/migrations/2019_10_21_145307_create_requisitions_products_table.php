<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitionsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('requisition_category_id');
            $table->string('name', 100)->nullable();
            $table->foreign('requisition_category_id')->references('id')->on('requisitions_categories');
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
        Schema::dropIfExists('requisitions_products');
    }
}
