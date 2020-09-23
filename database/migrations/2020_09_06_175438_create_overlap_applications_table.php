<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverlapApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ,'c1_id','c1_teacher_id','c1_status','c2_id','c2_teacher_id','c2_status'
        Schema::create('overlap_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->string("term");
            $table->unsignedBigInteger('c1_id');
            $table->foreign('c1_id')->references('id')->on('courses');
            $table->unsignedBigInteger('c2_id');
            $table->foreign('c2_id')->references('id')->on('courses');
            $table->unsignedBigInteger('c1_teacher_id');
            $table->foreign('c1_teacher_id')->references('id')->on('teachers');
            $table->unsignedBigInteger('c2_teacher_id');
            $table->foreign('c2_teacher_id')->references('id')->on('teachers');
            $table->integer("c1_status")->default(0);
            $table->integer("c2_status")->default(0);
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
        Schema::dropIfExists('overlap_applications');
    }
}
