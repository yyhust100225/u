<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDeparturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('employee_departures');
        Schema::create('employee_departures', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id')->comment('员工表ID');
            $table->date('departure_date')->nullable()->comment('离职时间');
            $table->unsignedTinyInteger('departure_type')->default(0)->comment('离职方式 0辞职 1辞退');
            $table->text('conversation_content')->comment('离职面谈详情');
            $table->string('direction', 255)->comment('离职去向');
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
        Schema::dropIfExists('employee_departures');
    }
}
