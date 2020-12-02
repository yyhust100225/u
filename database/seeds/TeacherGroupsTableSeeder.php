<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teacher_groups')->insert([
            ['name' => '教师组'],
            ['name' => '数资组'],
            ['name' => '语言组'],
            ['name' => '判断组'],
            ['name' => '申论组'],
            ['name' => '面试组'],
            ['name' => '师资管理中心'],
        ]);
    }
}
