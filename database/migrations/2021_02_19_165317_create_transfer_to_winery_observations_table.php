<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferToWineryObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_to_winery_observations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('transfer_to_winery_id');
            $table->unsignedInteger('purchase_product_id');
            $table->unsignedInteger('product_id');
            $table->longText('observations');
            $table->string('date');
            $table->decimal('qty',10,2);
            $table->decimal('qty_falt',10,2);
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
        Schema::dropIfExists('transfer_to_winery_observations');
    }
}
