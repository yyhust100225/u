<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('employee_educations');
        Schema::create('employee_educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id')->comment('员工表ID');
            $table->string('educational_background', 255)->default('')->comment('学历背景');
            $table->string('academic_degree', 255)->default('')->comment('学位');
            $table->string('major', 255)->default('')->comment('专业');
            $table->string('university', 255)->default('')->comment('毕业院校');
            $table->string('learn_model', 255)->default('')->comment('学习模式');
            $table->string('graduate_date', 255)->default('')->comment('毕业时间');
            $table->string('other_certificates', 255)->default('')->comment('其他证书');
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
        Schema::dropIfExists('employee_educations');
    }
}
