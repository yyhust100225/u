<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id')->comment('学员信息ID');
            $table->unsignedInteger('discount_id')->comment('优惠ID');
            $table->unsignedTinyInteger('discount_type')->comment('优惠类型 1考试优惠 2班型优惠');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_discounts');
    }
}
