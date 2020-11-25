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
            $table->string('tq_id')->comment('TQ学员信息ID');
            $table->string('name', 255)->comment('学员姓名');
            $table->string('mobile', 32)->default('')->comment('学员手机号');
            $table->string('ID_card_no', 32)->default('')->comment('学员身份证号');
            $table->text('remark')->comment('学员备注');
            $table->unsignedInteger('class_course_id')->comment('报名班级ID');
            $table->date('class_open_date')->nullable()->comment('开课日期');
            $table->string('admission_ticket_no', 255)->default('')->comment('准考证号');
            $table->string('applicant_company', 255)->default('')->comment('报考单位');
            $table->string('applicant_job', 255)->default('')->comment('报考职位');
            $table->unsignedInteger('applicant_num')->default(0)->comment('申请人数量');
            $table->unsignedInteger('applicant_percent_molecule')->default(0)->comment('招考比例分子');
            $table->unsignedInteger('applicant_percent_denominator')->default(1)->comment('招考比例分母');
            $table->unsignedInteger('rank')->default(1)->comment('排名');
            $table->unsignedInteger('difference')->default(0)->comment('分差');
            $table->unsignedInteger('person_in_charge')->comment('咨询负责人');
            $table->unsignedInteger('campus')->comment('所属校区');
            $table->decimal('receivable_amount', 10, 2)->default(0.00)->comment('应收款项');
            $table->decimal('discount_amount', 10, 2)->default(0.00)->comment('优惠金额');
            $table->decimal('paid_amount', 10, 2)->default(0.00)->comment('已缴金额');
            $table->decimal('written_examination_refund', 10, 2)->default(0.00)->comment('笔试退费金额');
            $table->decimal('interview_refund', 10, 2)->default(0.00)->comment('面试退费金额');
            $table->unsignedInteger('user_id')->comment('录入人');
            $table->timestamps();
            $table->index('class_course_id');
            $table->index('tq_id');
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
