<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AssignmentSkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('assignment_skills')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        //get courses
        $courses = Course::all();
        foreach($courses as $course){
            //get assignments and skills
            $assignments = $course->assignments;
            $skills = $course->skills->pluck('id')->toArray();
            if(empty($skills)) continue;
            //link a random amount of skills to each assignment
            foreach($assignments as $assignment){
                $chosenSkills = Arr::random($skills, rand(0,count($skills)));
                if(empty($chosenSkills)) continue;
                $assignment->skills()->syncWithPivotValues($chosenSkills, ['assignment_id' =>  $assignment->id]);
            }
        }
    }
}
