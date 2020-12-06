<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('payment_id')->comment('缴费记录ID');
            $table->unsignedInteger('payment_method')->comment('缴费方式');
            $table->decimal('pay_amount', 10, 2)->default(0.00)->comment('缴费数额');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_payment_details');
    }
}
