<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('identy')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedInteger('gender_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->unsignedInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedInteger('contact_source_id')->nullable();
            $table->foreign('contact_source_id')->references('id')->on('contact_sources');
            $table->unsignedInteger('eps_id')->nullable();
            $table->foreign('eps_id')->references('id')->on('filters');
            $table->unsignedInteger('civil_status_id')->nullable();
            $table->foreign('civil_status_id')->references('id')->on('filters');
            $table->string('ocupation')->nullable();
            $table->string('linkage')->nullable();
            $table->string('phone')->nullable();
            $table->string('cellphone')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('f_name')->nullable();
            $table->string('f_phone')->nullable();
            $table->string('f_relationship')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['activo','inactivo','delete'])->default('activo');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->unsignedInteger('user_id')->default(1);
            $table->foreign('user_id')->references('id')->on('users');
            $table->longText('observations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
