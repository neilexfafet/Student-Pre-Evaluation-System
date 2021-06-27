<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('course_code');
            $table->string('title');
            $table->tinyInteger('lec')->nullable();
            $table->tinyInteger('lab')->nullable();
            $table->tinyInteger('units');
            $table->unsignedBigInteger('pre_req_id')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->string('type')->nullable();
            $table->string('special_pre_req')->nullable();
            $table->tinyInteger('is_active')->default('1');
            $table->timestamps();
            
            $table->foreign('pre_req_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
