<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapNoticeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_notice_to_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('notice_id')->comment('要讯ID');
            $table->unsignedInteger('user_id')->comment('用户ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_notice_to_users');
    }
}
