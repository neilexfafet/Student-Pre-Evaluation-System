<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('student_no')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name'->nullable());
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('facebook_account')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('year_level')->default('1');
            $table->string('contact_no')->nullable();
            $table->string('emerg_contact')->nullable();
            $table->string('emerg_contact_no')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('status')->nullable();
            $table->string('is_active')->default('1');
            $table->timestamps();
            
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
        Schema::dropIfExists('students');
    }
}
