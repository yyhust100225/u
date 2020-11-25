<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTqStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tq_students', function (Blueprint $table) {
            $table->id();
            $table->string('tq_id', 32)->comment('TQ学员信息ID号');
            $table->string('admin_uin', 32)->comment('校区TQ总账户号');
            $table->string('uin', 32)->comment('资源所属人TQ号');
            $table->string('creator_uin', 255)->comment('资源录入人TQ号');
            $table->string('address', 255)->default('')->comment('学员现居地址');
            $table->string('mobile', 32)->default('')->comment('学员联系方式');
            $table->string('name', 255)->comment('学员姓名');
            $table->string('qq', 16)->comment('学员QQ号');
            $table->unsignedTinyInteger('level')->default(5)->comment('客户级别');
            $table->text('remark')->nullable()->comment('最近备注');
            $table->unsignedTinyInteger('gender')->default(1)->comment('客户性别 1男 2女');
            $table->string('telephone', 64)->default('')->comment('客户联系方式');
            $table->string('wechat', 255)->default('')->comment('客户微信号');
            $table->dateTime('insert_time')->comment('资源录入时间');
            $table->dateTime('last_contact_time')->nullable()->comment('上次联系时间');
            $table->unsignedInteger('phone_calls')->default(0)->comment('去电次数');
            $table->dateTime('update_time')->nullable()->comment('最后更新时间');
            $table->unsignedInteger('department_id')->default(0)->comment('所属部门');
            $table->unsignedTinyInteger('party_number')->default(0)->comment('是否为党员 0非党员 1党员');
            $table->string('attestation', 255)->default('')->comment('资格证');
            $table->string('school', 255)->default('')->comment('毕业院校');
            $table->string('major', 255)->default('')->comment('专业');
            $table->string('company', 255)->default('')->comment('报考单位');
            $table->string('job', 255)->default('')->comment('报考职位');
            $table->string('ID_card_no', 255)->default('')->comment('身份证号');
            $table->string('examination', 255)->default('')->comment('考试');
            $table->string('class_type', 255)->default('')->comment('班型');
            $table->string('political', 255)->default('')->comment('政治面貌');
            $table->string('english_level', 255)->default('')->comment('英语四六级');
            $table->string('current_address', 255)->default('')->comment('目前所在地');
            $table->string('resource_owner', 255)->default('')->comment('资源获取人');
            $table->string('resource_activity', 255)->default('')->comment('资源归属活动');
            $table->date('visit_back_date')->nullable()->comment('回访日期');
            $table->date('call_back_date')->nullable()->comment('回拨日期');
            $table->unsignedInteger('way_to_visit')->default(0)->comment('来访途径');
            $table->unsignedTinyInteger('exam_type')->default(0)->comment('考试方式 1面试 2笔试');
            $table->unsignedInteger('belong_to')->default(0)->comment('归属地');
            $table->unsignedInteger('education')->default(0)->comment('学历');
            $table->unsignedInteger('identity')->default(0)->comment('考生身份');
            $table->unsignedInteger('common_tested')->default(0)->comment('参加公考');
            $table->unsignedInteger('trained')->default(0)->comment('参加培训');
            $table->unsignedInteger('resource_method')->default(0)->comment('获取资源方式');
            $table->unsignedInteger('belongs_to_department')->default(0)->comment('资源归属部门');
            $table->unsignedInteger('tq_synchronization')->default(2)->comment('是否从TQ中录入本地库 1否 2是');
            $table->unsignedInteger('user_id')->comment('同步账户ID');
            $table->timestamp('create_time')->useCurrent()->comment('录入时间');
            $table->index('uin');
            $table->unique('tq_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tq_students');
    }
}