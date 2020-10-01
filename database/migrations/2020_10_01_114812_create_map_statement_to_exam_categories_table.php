<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapStatementToExamCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_statement_to_exam_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('statement_id')->comment('账单ID');
            $table->unsignedInteger('exam_category_id')->comment('考试大类ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_statement_to_exam_categories');
    }
}
