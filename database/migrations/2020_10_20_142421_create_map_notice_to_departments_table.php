<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapNoticeToDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_notice_to_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('notice_id')->comment('要讯ID');
            $table->unsignedInteger('department_id')->comment('部门ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_notice_to_departments');
    }
}
