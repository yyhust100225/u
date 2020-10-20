<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapNoticeToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_notice_to_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('notice_id')->comment('要讯ID');
            $table->unsignedInteger('role_id')->comment('角色ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_notice_to_roles');
    }
}
