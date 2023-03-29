<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationSurgeryExpensesSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_surgery_expenses_sheet', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('surgery_expenses_sheet_id')->index('surgery_expenses_sheet_index')->nullable();
            $table->foreign('surgery_expenses_sheet_id', 'surgery_expenses_sheet_id_foreign')->references('id')->on('surgery_expenses_sheet');
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
        Schema::dropIfExists('relation_surgery_expenses_sheet');
    }
}
