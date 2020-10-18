<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapStatementToExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_statement_to_exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('statement_id')->comment('账单ID');
            $table->unsignedInteger('exam_id')->comment('考试ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_statement_to_exams');
    }
}
