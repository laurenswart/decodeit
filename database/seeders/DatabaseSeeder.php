<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Message;
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
            ChaptersReadSeeder::class,//no need to check from here further
            SkillSeeder::class,
            StudentSkillSeeder::class,
            AssignmentSeeder::class,
            MessageSeeder::class,//done
            AssignmentNoteSeeder::class,
            AssignmentChapterSeeder::class,
        ]);
        
        
    }
}
