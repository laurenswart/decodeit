<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Message;
use App\Models\StudentAssignment;
use App\Models\Submission;
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
            
            PlansSeeder::class,
            StripeSeeder::class,
            UserSeeder::class,
            
            TeacherStudentSeeder::class,
            CourseSeeder::class,
            EnrolmentSeeder::class,
            
            ChaptersReadSeeder::class,
            SkillSeeder::class,
            StudentSkillSeeder::class,
           
            MessageSeeder::class,
            AssignmentNoteSeeder::class,
            AssignmentSkillsSeeder::class,
            
            StudentAssignmentSeeder::class,
            SubmissionSeeder::class,
            AdminSeeder::class
        ]);
        
        
        
    }
}
