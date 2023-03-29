<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_role', function (Blueprint $table) {
            $table->boolean('visible')->default(true)->nullable();
            $table->boolean('create')->default(true)->nullable();
            $table->boolean('update')->default(true)->nullable();
            $table->boolean('delete')->default(true)->nullable();
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('menu_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_role');
    }
}
