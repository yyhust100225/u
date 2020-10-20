<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('employee_salaries');
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id')->comment('员工表ID');
            $table->decimal('base_salary_1', 10,2)->default(0.00)->comment('基本工资1');
            $table->decimal('base_salary_2', 10,2)->default(0.00)->comment('基本工资2');
            $table->decimal('merits_salary', 10,2)->default(0.00)->comment('绩效工资');
            $table->decimal('job_subsidy', 10,2)->default(0.00)->comment('岗位补助');
            $table->decimal('live_subsidy', 10,2)->default(0.00)->comment('生活补助');
            $table->decimal('local_subsidy', 10,2)->default(0.00)->comment('地方补助');
            $table->decimal('public_service_subsidy', 10,2)->default(0.00)->comment('公共服务补助');
            $table->decimal('class_subsidy', 10,2)->default(0.00)->comment('课时补助');
            $table->decimal('no_insurance_subsidy', 10,2)->default(0.00)->comment('放弃保险补助');
            $table->decimal('other_subsidy', 10,2)->default(0.00)->comment('其他补助');
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
        Schema::dropIfExists('employee_salaries');
    }
}
