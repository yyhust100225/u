<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('book_buyers')) {
            Schema::create('book_buyers', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('book_sale_id')->comment('图书销售ID');
                $table->string('name', 255)->comment('买家姓名');
                $table->unsignedTinyInteger('gender')->default(0)->comment('性别 0男 1女');
                $table->string('id_number', 32)->default('')->comment('身份证号');
                $table->string('tel', 255)->default('')->comment('联系方式');
                $table->unsignedInteger('quantity')->default(0)->comment('销售数量');
                $table->unsignedTinyInteger('payment_method')->default(0)->comment('缴费方式');
                $table->decimal('cost', 8, 2)->default(0.00)->comment('销售费用');
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
        Schema::dropIfExists('book_buyers');
    }
}
