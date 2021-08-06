<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department', function (Blueprint $table) {
            $table->integer('department_id')->primary();
            $table->integer('parent_department_id')->nullable();
            $table->string('department_name', 45);
            $table->string('description')->nullable();
            $table->string('created_by', 45)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->string('last_modified_by', 45)->nullable();
            $table->dateTime('last_modified_date')->nullable();
            $table->smallInteger('record_status')->nullable();
            $table->foreign('parent_department_id')->references('department_id')->on('department')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department');
    }
}
