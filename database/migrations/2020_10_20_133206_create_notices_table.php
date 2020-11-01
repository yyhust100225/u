<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('notices');
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title', 512)->comment('要讯标题');
            $table->unsignedTinyInteger('notice_type_id')->comment('要讯种类');
            $table->date('start_time')->nullable()->comment('开始时间');
            $table->date('end_time')->nullable()->comment('结束时间');
            $table->unsignedInteger('file_id')->default(0)->comment('要讯附件文件ID');
            $table->text('content')->comment('要讯内容');
            $table->unsignedInteger('user_id')->comment('创建用户ID');
            $table->unsignedTinyInteger('status')->default(0)->comment('要讯状态');
            $table->unsignedInteger('reviewer_id')->default(0)->comment('审核人ID');
            $table->dateTime('review_time')->nullable()->comment('审核时间');
            $table->string('review_remark', 512)->default('')->comment('审核备注');
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
        Schema::dropIfExists('notices');
    }
}
