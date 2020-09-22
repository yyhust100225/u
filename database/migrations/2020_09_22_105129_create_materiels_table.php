<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterielsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->comment('物料名称');
            $table->unsignedInteger('department_id')->comment('所属部门ID');
            $table->unsignedInteger('quantity_total')->default(0)->comment('总数');
            $table->unsignedInteger('quantity_scrap')->default(0)->comment('报废数量');
            $table->unsignedInteger('quantity_consume')->default(0)->comment('消耗数量');
            $table->unsignedInteger('quantity_incomplete')->default(0)->comment('零件残缺数量');
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
        Schema::dropIfExists('materiels');
    }
}
