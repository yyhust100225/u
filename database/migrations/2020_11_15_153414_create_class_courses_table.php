<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('考试名称');
            $table->unsignedInteger('class_type_id')->comment('所属班型ID');
            $table->unsignedInteger('class_course_type_id')->comment('开课类型ID');
            $table->unsignedInteger('department_id')->comment('开课校区ID');
            $table->string('address', 255)->comment('开课具体地址');
            $table->unsignedInteger('day_num')->default(0)->comment('开课天数');
            $table->unsignedInteger('max_person_num')->default(0)->comment('封班人数');
            $table->unsignedTinyInteger('in_hotel')->default(0)->comment('是否住店 0否 1是');
            $table->date('in_hotel_date')->nullable()->comment('学生住店日期');
            $table->text('remark')->comment('备注');
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
        Schema::dropIfExists('class_courses');
    }
}
