<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('班型名称');
            $table->unsignedInteger('examination_id')->comment('所属考试ID');
            $table->unsignedTinyInteger('is_agreement_class')->default(0)->comment('是否为协议班 0否 1是');
            $table->unsignedTinyInteger('exam_type')->comment('考试形式');
            $table->unsignedInteger('written_examination_days')->default(0)->comment('笔试白天数');
            $table->unsignedInteger('written_examination_nights')->default(0)->comment('笔试夜晚数');
            $table->unsignedInteger('interview_days')->default(0)->comment('面试白天数');
            $table->unsignedInteger('interview_nights')->default(0)->comment('面试夜晚数');
            $table->decimal('total_tuition', 10, 2)->default(0.00)->comment('总学费');
            $table->decimal('per_day_tuition', 10, 2)->default(0.00)->comment('每日学费');
            $table->decimal('written_examination_refund', 10, 2)->default(0.00)->comment('笔试退款');
            $table->decimal('interview_refund', 10, 2)->default(0.00)->comment('面试退款');
            $table->unsignedTinyInteger('status')->default(1)->comment('班型状态 0关闭 1开启');
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
        Schema::dropIfExists('class_types');
    }
}
