<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseFeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_fees')->insert([
            ['name' => '助教', 'fee' => 20.00],
            ['name' => '培训期', 'fee' => 30.00],
            ['name' => '实习期', 'fee' => 35.00],
            ['name' => '初一', 'fee' => 45.00],
            ['name' => '初二', 'fee' => 50.00],
            ['name' => '初三', 'fee' => 55.00],
            ['name' => '中一', 'fee' => 60.00],
            ['name' => '中二', 'fee' => 65.00],
            ['name' => '中三', 'fee' => 70.00],
            ['name' => '中四', 'fee' => 80.00],
            ['name' => '高一', 'fee' => 90.00],
            ['name' => '高二', 'fee' => 100.00]
        ]);
    }
}
