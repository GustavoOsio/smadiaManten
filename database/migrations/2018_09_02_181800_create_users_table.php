<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->index();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('title')->nullable();
            $table->string('name');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('identy');
            $table->date('date_expedition');
            $table->date('birthday');
            $table->unsignedInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedInteger('gender_id');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->string('address');
            $table->string('urbanization')->nullable();
            $table->string('phone');
            $table->string('phone_two')->nullable();
            $table->string('cellphone');
            $table->string('cellphone_two')->nullable();
            $table->string('email')->unique();
            $table->string('email_two')->nullable();
            $table->string('password');
            $table->unsignedInteger('arl_id')->nullable();
            $table->foreign('arl_id')->references('id')->on('filters');
            $table->unsignedInteger('pension_id')->nullable();
            $table->foreign('pension_id')->references('id')->on('filters');
            $table->unsignedInteger('blood_id');
            $table->foreign('blood_id')->references('id')->on('bloods');
            $table->string('f_name');
            $table->string('f_lastname');
            $table->string('f_address');
            $table->string('f_phone');
            $table->string('f_cellphone');
            $table->string('f_relationship');
            $table->string('photo')->nullable();
            $table->string('color')->nullable();
            $table->enum('status', ['activo','inactivo'])->default('activo');
            $table->enum('schedule', ['si','no'])->default('no');
            $table->unsignedInteger('cellar_id')->nullable();
            $table->decimal('commission_income',3,2)->default(0)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
