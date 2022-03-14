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
        $courses = Course::all();
        foreach($courses as $course){
            $assignments = $course->assignments;
            $skills = $course->skills->pluck('skill_id')->toArray();
            foreach($assignments as $assignment){
                $chosenSkills = Arr::random($skills, rand(0,count($skills)));
                $assignment->skills()->syncWithPivotValues($chosenSkills, ['assignment_ref' =>  $assignment->assignment_id]);
            }
        }
    }
}
