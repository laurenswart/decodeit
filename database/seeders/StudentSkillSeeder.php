<?php

namespace Database\Seeders;

use App\Models\Enrolment;
use App\Models\StudentSkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        //Empty the table first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        StudentSkill::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //find enrolments
        $enrolments = Enrolment::all();

        foreach($enrolments as $enrolment){
            //get the skills in that course
            $skills = $enrolment->course->skills;
            //var_dump($skills);
            //var_dump($enrolment->course);
            //if($skills->empty()) continue;
            $skills = $skills->toArray();
            $nbSkillsMarked = rand(0, count($skills));
            var_dump($nbSkillsMarked);
            if($nbSkillsMarked==0) continue;
            //mark some skills
            $skillsMarkedIds = array_rand($skills, $nbSkillsMarked);
            $skillsMarkedIds = is_int($skillsMarkedIds) ? [$skillsMarkedIds] : $skillsMarkedIds;
            foreach($skillsMarkedIds as $skillMarkedId){
                $rows[] = [
                    'enrolment_ref'=>$enrolment->enrolment_id,
                    'skill_ref'=>$skills[$skillMarkedId]['skill_id'],
                    'mark'=> rand(10, 100),
                ];
            }
            //insert into table
            DB::table('student_skills')->insert($rows);
            $rows = [];
            unset($rows);
        }
    }
}
