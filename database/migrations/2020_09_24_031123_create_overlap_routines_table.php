<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverlapRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overlap_routines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->json("data");
            $table->string("term");
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
        Schema::dropIfExists('overlap_routines');
    }
}
