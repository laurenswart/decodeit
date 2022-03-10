<?php

namespace Database\Seeders;

use App\Models\Chapter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            RoleSeeder::class,
            UserSeeder::class,
            SubscriptionsSeeder::class,
            PaymentsSeeder::class,
            TeacherStudentSeeder::class,
            CourseSeeder::class,
            EnrolmentSeeder::class,
            ChapterSeeder::class,
            ChaptersReadSeeder::class,
        ]);
        
        
    }
}
