<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment('公告标题');
            $table->unsignedInteger('city_id')->comment('城市ID');
            $table->unsignedInteger('announcement_type')->comment('公告类型');
            $table->string('link', 255)->default('')->comment('链接');
            $table->char('level')->default('A')->comment('等级');
            $table->date('publish_date')->nullable()->comment('发布时间');
            $table->unsignedInteger('candidate_num')->default(0)->comment('招考人数');
            $table->date('enroll_date_start')->nullable()->comment('报名开始时间');
            $table->date('enroll_end_start')->nullable()->comment('报名截止时间');
            $table->tinyInteger('enroll_type')->default(0)->comment('报名形式');
            $table->tinyInteger('exam_type')->default(0)->comment('考试形式');
            $table->unsignedInteger('written_exam_activity_num')->default(0)->comment('笔试活动人数');
            $table->date('written_exam_date')->nullable()->comment('笔试考试时间');
            $table->unsignedTinyInteger('written_exam_class_open')->default(0)->comment('笔试是否开课');
            $table->unsignedTinyInteger('written_exam_take_problem_sets')->default(0)->comment('笔试是否拿习题');
            $table->unsignedInteger('written_exam_in_examination_num')->default(0)->comment('笔试参加开始人数');
            $table->date('check_qualification_date')->nullable()->comment('资格审查时间');
            $table->unsignedInteger('interview_activity_num')->default(0)->comment('面试活动人数');
            $table->date('interview_date')->nullable()->comment('面试时间');
            $table->unsignedTinyInteger('interview_class_open')->default(0)->comment('面试是否开课');
            $table->unsignedTinyInteger('interview_take_problem_sets')->default(0)->comment('面试是否拿题');
            $table->decimal('pass_percent', 8, 2)->default(0.00)->comment('自然通过率');
            $table->unsignedTinyInteger('status')->default(0)->comment('公告状态');
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
        Schema::dropIfExists('class_announcements');
    }
}
