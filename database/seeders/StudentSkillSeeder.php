<?php

namespace Database\Seeders;

use App\Models\Enrolment;
use App\Models\Student;
use App\Models\StudentSkill;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StudentSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '2048M');
        //Empty the table first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        StudentSkill::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //find enrolments per teacher to avoid memory size exhaustion
        $enrolments = Enrolment::all();
        foreach($enrolments as $enrolment){
            $rows = [];
            //get the skills in that course
            $skills = $enrolment->course->skills;
            $skills = $skills->toArray();
            $nbSkillsMarked = rand(0, count($skills));
            
            if($nbSkillsMarked==0) continue;
            //mark some skills
            $skillsMarked = Arr::random($skills, $nbSkillsMarked);
            foreach($skillsMarked as $skillMarked){
                $rows[] = [
                    'enrolment_id'=>$enrolment->id,
                    'skill_id'=>$skillMarked['id'],
                    'mark'=> rand(10, 100),
                ];
            }
            //insert into table
            DB::table('student_skills')->insert($rows);
            
            unset($rows);
        }
    }
}
