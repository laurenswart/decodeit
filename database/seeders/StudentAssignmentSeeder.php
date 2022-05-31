<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Enrolment;
use App\Models\StudentAssignment;
use App\Models\Submission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        StudentAssignment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        //get assignments
        $assignment = Assignment::all();
        foreach($assignment as $assignment){
            if($assignment->start_time_carbon()->gt(now()) ) continue;
            //get enrolments
            $enrolments = $assignment->course->enrolments;
            foreach($enrolments as $enrolment){
                //50% chance of creating student assignment
                if(rand(1,10)<=5) continue;
                //create student assignment
                $toMark = rand(1,10)<=3;
                $studentAssignmentId = StudentAssignment::insertGetId([
                    'enrolment_id'=>$enrolment->id,
                    'assignment_id'=>$assignment->id,
                    'to_mark'=> $toMark ? 1 : 0,
                    'mark'=> $toMark ? rand(0,$assignment->max_mark) : null,
                    'marked_at' => now(),
                ]);
            }
        }
    }
}
