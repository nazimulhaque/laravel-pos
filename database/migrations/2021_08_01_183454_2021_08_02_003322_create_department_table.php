<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('department_name');
            $table->text('description')->nullable();
            // $table->string('image')->nullable();
            // $table->string('barcode')->unique();
            // $table->decimal('price', 8, 2);
            // $table->boolean('status')->default(true);
            // $table->timestamps();
            $table->foreign('parent_department_id')
                ->references('department_id')->on('department')
                ->onDelete('cascade');
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
