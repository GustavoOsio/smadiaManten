<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemsReviewRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems_review_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('system_review_id')->nullable();
            $table->foreign('system_review_id')->references('id')->on('system_review');
            $table->unsignedInteger('systems_id')->nullable();
            $table->foreign('systems_id')->references('id')->on('systems');
            $table->string('pathology');
            $table->string('select');
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
        Schema::dropIfExists('systems_review_relation');
    }
}
