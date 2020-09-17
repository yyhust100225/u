<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->comment('图书名称');
            $table->unsignedInteger('department_id')->comment('所属部门ID');
            $table->unsignedInteger('quantity_total')->default(0)->comment('总数');
            $table->unsignedInteger('quantity_sold')->default(0)->comment('售出数量');
            $table->unsignedInteger('quantity_give')->default(0)->comment('赠送数量');
            $table->unsignedInteger('quantity_return')->default(0)->comment('归还数量');
            $table->unsignedInteger('quantity_usable')->default(0)->comment('可用数量');
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
        Schema::dropIfExists('books');
    }
}
