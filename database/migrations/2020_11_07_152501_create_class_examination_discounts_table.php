<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassExaminationDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_examination_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('examination_id')->comment('所属考试ID');
            $table->unsignedInteger('discount_type_id')->comment('优惠类型ID');
            $table->decimal('amount')->default(0.00)->comment('优惠金额');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0停用 1启用');
            $table->unsignedInteger('user_id')->comment('创建人');
            $table->text('remark')->comment('备注');
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
        Schema::dropIfExists('class_examination_discounts');
    }
}
