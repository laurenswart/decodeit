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
            PlansSeeder::class,
            StripeSeeder::class,
            
            
            TeacherStudentSeeder::class,
            CourseSeeder::class,
            EnrolmentSeeder::class,
            
            ChaptersReadSeeder::class,
            SkillSeeder::class,
            StudentSkillSeeder::class,
           
            MessageSeeder::class,
            AssignmentNoteSeeder::class,
            AssignmentSkillsSeeder::class,
            
        ]);
        
        
    }
}
