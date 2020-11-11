<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTypeDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_type_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('type_id')->comment('所属班型ID');
            $table->string('name', 255)->comment('优惠名称');
            $table->decimal('amount', 10, 2)->default('0.00')->comment('优惠价格');
            $table->date('start_date')->comment('开始日期');
            $table->date('end_date')->comment('结束日期');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态');
            $table->unsignedInteger('user_id')->comment('录入人');
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
        Schema::dropIfExists('class_type_discounts');
    }
}
