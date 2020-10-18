<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('book_sales')) {
            Schema::create('book_sales', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('book_id')->comment('图书ID');
                $table->unsignedInteger('department_id')->comment('归属部门');
                $table->unsignedInteger('user_id')->comment('归属人ID');
                $table->text('remark')->comment('销售记录备注');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_sales');
    }
}
