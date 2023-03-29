<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationExpensesSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_expenses_sheet', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('expenses_sheet_id')->index('expenses_sheet_index')->nullable();
            $table->foreign('expenses_sheet_id', 'expenses_sheet_id_foreign')->references('id')->on('expenses_sheet');
            $table->string('code');
            $table->string('product');
            $table->string('lote');
            $table->string('presentation');
            $table->string('medid');
            $table->unsignedInteger('cant');
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
        Schema::dropIfExists('relation_expenses_sheet');
    }
}
