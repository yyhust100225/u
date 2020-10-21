<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('employees');
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('员工姓名');
            $table->unsignedInteger('user_id')->comment('账户表ID');
            $table->unsignedTinyInteger('status')->default(0)->comment('员工状态 0试用期 1正式 2离职');
            $table->string('job_no', 6)->comment('员工工号');
            $table->unsignedTinyInteger('department_id')->comment('部门ID');
            $table->unsignedTinyInteger('group_id')->default(0)->comment('组别ID');
            $table->unsignedTinyInteger('job_id')->comment('职务ID');
            $table->string('TQ_no', 255)->default('')->comment('员工TQ号');
            $table->string('level', 255)->default('')->comment('员工等级');
            $table->string('alias', 255)->default('')->comment('教师别名(艺名)');
            $table->unsignedTinyInteger('gender')->default(0)->comment('员工性别 0男 1女');
            $table->unsignedTinyInteger('nation_id')->comment('民族');
            $table->unsignedTinyInteger('political_status')->default(0)->comment('政治身份 0群众 1党员');
            $table->unsignedTinyInteger('marry')->default(0)->comment('婚姻状态 0未婚 1已婚');
            $table->unsignedTinyInteger('register_residence_type')->default(0)->comment('户口类型 0农村 1城镇');
            $table->date('hire_date')->nullable()->comment('入职日期');
            $table->unsignedTinyInteger('regular')->default(0)->comment('是否转正 0否 1是');
            $table->date('regular_date')->nullable()->comment('转正日期');
            $table->date('insurance_date')->nullable()->comment('入保日期');
            $table->date('last_contract_date')->nullable()->comment('合同签署日期');
            $table->date('contract_expire_date')->nullable()->comment('合同到期日期');
            $table->unsignedTinyInteger('insurance_area_id')->default(0)->comment('缴纳保险地区ID');
            $table->string('staff_no', 255)->default('')->comment('职员编号');
            $table->string('paf_no', 255)->default('')->comment('公积金账号');
            $table->string('mic_no', 255)->default('')->comment('医保卡账号');
            $table->unsignedTinyInteger('teacher_certification')->default(0)->comment('教师资格证 0未持有 1持有');
            $table->date('birthday')->nullable()->comment('员工生日');
            $table->string('id_card_no', 255)->default('')->comment('员工身份证号');
            $table->string('id_card_address', 512)->default('')->comment('身份证地址');
            $table->string('current_address', 512)->default('')->comment('现居住地址');
            $table->string('tel', 64)->default('')->comment('电话号/联系方式');
            $table->string('emergency_contact', 255)->default('')->comment('紧急联系人');
            $table->string('emergency_tel', 255)->default('')->comment('紧急联系方式');
            $table->string('bank_card_no_5', 255)->default('')->comment('工资卡号(5日)');
            $table->string('bank_of_account_5', 255)->default('')->comment('开户行(5日)');
            $table->string('bank_card_no_10', 255)->default('')->comment('工资卡号(10日)');
            $table->string('bank_of_account_10', 255)->default('')->comment('开户行(10日)');
            $table->text('work_experience')->comment('员工工作经历');
            $table->text('exception_action')->comment('员工异动记录');
            $table->text('leave_records')->comment('员工休假记录');
            $table->text('remark')->comment('员工备注');
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
        Schema::dropIfExists('employees');
    }
}
