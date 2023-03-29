<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliciesPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies_patients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contract_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('responsable_id')->nullable();
            $table->string('type',255)->default('firma');
            $table->longText('file')->nullable();
            $table->longText('link')->nullable();
            $table->string('user',255)->nullable();
            $table->string('password',255)->nullable();
            $table->unsignedInteger('validate')->default(1);
            $table->longText('signatureBase64')->nullable();
            $table->string('authorize',255)->default('NO');
            $table->longText('signature')->nullable();
            $table->string('status',255)->default('PENDIENTE');
            $table->longText('token')->nullable();
            $table->string('date','100')->nullable();
            $table->string('group_1','100')->nullable();
            $table->string('group_2','100')->nullable();
            $table->string('group_3','100')->nullable();
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
        Schema::dropIfExists('policies_patients');
    }
}
