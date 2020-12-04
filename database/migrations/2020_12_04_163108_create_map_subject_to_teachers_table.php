<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapSubjectToTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_subject_to_teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('subject_id')->comment('科目ID');
            $table->unsignedInteger('teacher_id')->comment('教师ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_subject_to_teachers');
    }
}
