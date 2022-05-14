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
            RoleSeeder::class,//ok
            UserSeeder::class,//ok
            PlansSeeder::class,
            PaymentsSeeder::class,
            TeacherStudentSeeder::class,//ok
            CourseSeeder::class,//ok
            EnrolmentSeeder::class,//ok
            
            ChaptersReadSeeder::class,
            SkillSeeder::class,
            StudentSkillSeeder::class,
           
            MessageSeeder::class,
            AssignmentNoteSeeder::class,
            
        ]);
        
        
    }
}
