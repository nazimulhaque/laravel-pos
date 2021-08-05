<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->integer('unit_id')->primary();
            $table->string('description', 45)->unique('description_UNIQUE');
            $table->string('created_by', 45)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->string('last_modified_by', 45)->nullable();
            $table->dateTime('last_modified_date')->nullable();
            $table->smallInteger('record_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit');
    }
}
