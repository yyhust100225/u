<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('老师姓名');
            $table->string('nickname', 255)->comment('老师艺名');
            $table->string('tel', 255)->comment('联系方式');
            $table->unsignedInteger('course_fee_id')->comment('课时费ID');
            $table->unsignedInteger('teacher_group_id')->comment('教师分组ID');
            $table->text('remark')->comment('备注');
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
        Schema::dropIfExists('teachers');
    }
}
