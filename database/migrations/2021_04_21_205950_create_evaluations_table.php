<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('evaluation_no');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('record_id');
            $table->double('grade', 10, 1)->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('year_level');
            $table->tinyInteger('semester');
            $table->year('school_year_from')->nullable();
            $table->year('school_year_to')->nullable();
            $table->timestamps();
            
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('record_id')->references('id')->on('records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
