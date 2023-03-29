<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignaturesContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatures_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contract_id')->nullable();
            $table->longText('link');
            $table->string('user',255);
            $table->string('password',255);
            $table->unsignedInteger('validate')->default(1);
            $table->longText('signatureBase64');
            $table->string('authorize',255)->default('NO');
            $table->longText('signature');
            $table->string('status',255)->default('PENDIENTE');
            $table->longText('token');
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
        Schema::dropIfExists('signatures_contracts');
    }
}
