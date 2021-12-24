<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRegistrationLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_registration_lecturers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('lecturer_id')->index()->unsigned();
            $table->foreign('lecturer_id')->references('id')->on('lecturers')->onDelete('cascade');
            $table->bigInteger('course_registration_id')->index()->unsigned();
            $table->foreign('course_registration_id')->references('id')->on('course_registrations')->onDelete('cascade');
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
        Schema::dropIfExists('course_registration_lecturers');
    }
}
