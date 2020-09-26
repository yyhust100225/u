<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('statements');
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('printer_id')->comment('印刷厂ID');
            $table->unsignedInteger('publisher_id')->comment('发稿人ID');
            $table->date('publish_date')->comment('发稿日期');
            $table->unsignedInteger('department_id')->comment('部门ID');
            $table->unsignedInteger('exam_category_id')->comment('考试大类ID');
            $table->unsignedInteger('exam_id')->comment('考试ID');
            $table->unsignedInteger('printed_matter_id')->comment('印刷品ID');
            $table->text('print_detail')->comment('印刷明细');
            $table->unsignedInteger('quantity_print')->default(0)->comment('印刷品数量');
            $table->decimal('price_print', 10, 2)->default(0.00)->comment('印刷品单价');
            $table->decimal('printer_quote_price', 10, 2)->default(0.00)->comment('印刷厂报价');
            $table->decimal('designer_quote_price', 10, 2)->default(0.00)->comment('设计师报价');
            $table->string('applicant', 255)->comment('申请人');
            $table->text('remark')->comment('对账单备注');
            $table->tinyInteger('status')->default(0)->comment('账单状态');
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
        Schema::dropIfExists('statements');
    }
}
