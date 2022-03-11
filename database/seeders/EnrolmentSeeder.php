<?php

namespace Database\Seeders;

use App\Models\Enrolment;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EnrolmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Enrolment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //get teachers
        $teachers = Teacher::all();
        
        foreach($teachers as $teacher){
            //get teacher's students
            $students = $teacher->students;
            //get teacher's courses that are not deleted
            $courses = $teacher->courses->where('deleted_at', NULL)->toArray();
            if(empty($courses)) continue;
            //enrol each student in a random amount of those courses
            foreach($students as $student){
                $nbCoursesChosen = rand(0,count($courses));
                if($nbCoursesChosen == 0) continue;
                /*
                $chosenCoursesIndexes = array_rand($courses, $nbCoursesChosen);
                $chosenCoursesIndexes = is_int($chosenCoursesIndexes) ? [$chosenCoursesIndexes] : $chosenCoursesIndexes;
                */
                $chosenCoursesIndexes = Arr::random($courses, $nbCoursesChosen);
                foreach($chosenCoursesIndexes as $chosenCourseIndex){
                    Enrolment::factory()->create([
                        'course_ref' => $courses[$chosenCourseIndex]['course_id'],
                        'student_ref'=> $student['user_id'],
                        'created_at' => $teacher['created_at'],
                        'marked_at' => date( 'Y-m-d H:i:s', min(time(), date_create($teacher->currentSubscription()->expires)->getTimestamp())),
                        'updated_at' => date( 'Y-m-d H:i:s', min(time(), date_create($teacher->currentSubscription()->expires)->getTimestamp())),
                    ]);
                }
            }

        }
    }
}
