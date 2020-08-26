<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string("course_code");
            $table->string("title");
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->integer("total_credits");
            $table->boolean("has_mid")->default(1);
            $table->boolean("has_final")->default(1);
            $table->boolean("has_lab")->default(1);
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
        Schema::dropIfExists('courses');
    }
}
