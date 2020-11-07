<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_examinations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('考试名称');
            $table->unsignedInteger('announcement_id')->comment('公告ID');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0停用 1启用');
            $table->text('remark')->comment('备注');
            $table->unsignedInteger('user_id')->comment('创建人');
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
        Schema::dropIfExists('class_examinations');
    }
}
