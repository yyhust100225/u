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
