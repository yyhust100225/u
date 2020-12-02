<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
//            UsersTableSeeder::class,
//            RolesTableSeeder::class,
//            PermissionsTableSeeder::class,
//            \Database\Seeders\AnnouncementTypeSeeder::class,
//        \Database\Seeders\ClassCourseTypesTableSeeder::class,
//        \Database\Seeders\CourseFeesTableSeeder::class,
            \Database\Seeders\TeacherGroupsTableSeeder::class,
        ]);
    }
}
