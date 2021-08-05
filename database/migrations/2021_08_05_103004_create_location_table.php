<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->integer('location_id')->primary();
            $table->string('location_name', 100)->unique('location_name_UNIQUE');
            $table->string('created_by', 45)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->dateTime('last_modified_date')->nullable();
            $table->string('last_modified_by', 45)->nullable();
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
        Schema::dropIfExists('location');
    }
}
