<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassCourseStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_course_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('class_course_id')->comment('班级ID');
            $table->unsignedInteger('student_id')->comment('学生ID');
            $table->unsignedTinyInteger('pass_status')->default(0)->comment('学员状态');
            $table->unsignedInteger('user_id')->comment('录入人');
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
        Schema::dropIfExists('class_course_students');
    }
}
