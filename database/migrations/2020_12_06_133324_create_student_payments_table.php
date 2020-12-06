<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id')->comment('学生ID');
            $table->decimal('total_amount', 10, 2)->default(0.00)->comment('实缴金额');
            $table->date('payment_date')->comment('缴费日期');
            $table->unsignedInteger('payment_place')->comment('缴费地');
            $table->string('bill_no', 255)->default('')->comment('票据号');
            $table->unsignedInteger('payment_type')->comment('缴费类型');
            $table->text('remark')->comment('缴费备注');
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
        Schema::dropIfExists('student_payments');
    }
}
