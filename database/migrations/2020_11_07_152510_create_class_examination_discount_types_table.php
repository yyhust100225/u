<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassExaminationDiscountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_examination_discount_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pid')->default(0)->comment('优惠类型父ID');
            $table->string('name')->comment('类型名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_examination_discount_types');
    }
}
