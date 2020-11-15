<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassCourseTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_course_types')->insert([
            ['name' => '正课'],
            ['name' => '一对一'],
            ['name' => '营销课'],
            ['name' => '网络课'],
            ['name' => '讲师培训'],
        ]);
    }
}
