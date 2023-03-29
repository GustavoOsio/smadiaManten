<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddElectronicEquipmentIdToServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedInteger("electronic_equipment_id")->index()->nullable();
            $table->foreign("electronic_equipment_id")->references("id")->on("electronic_equipments");
            $table->enum('depilcare', ['SI', 'NO'])->default('NO');
            $table->enum('type', ['sesion', 'aplicacion'])->default('sesion');
            $table->decimal('deducible',10,2)->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn("electronic_equipment_id");
            $table->dropColumn("depilcare");
        });
    }
}
