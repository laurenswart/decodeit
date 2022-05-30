<?php

namespace Database\Seeders;

use App\Models\Enrolment;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
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
        $rows = [];
        
        foreach($teachers as $teacher){
            $rows = [];
            //get teacher's students
            $students = $teacher->students;
            //get teacher's courses that are not deleted
            $courses = $teacher->courses->toArray();
            if(empty($courses)) continue;
            //enrol each student in a random amount of those courses
            foreach($students as $student){
                if($student->email=='lswart@gmail.com' && $teacher->email=='bsull@gmail.com'){
                    //add lswart to all of bobsull courses
                    $nbCoursesChosen  = count($courses);
                } else {
                    $nbCoursesChosen = rand(0,count($courses));
                }
                
                if($nbCoursesChosen == 0) continue;
                $chosenCourses = Arr::random($courses, $nbCoursesChosen);
                foreach($chosenCourses as $chosenCourse){
                    $minDate = Carbon::today()->subMonth(4);
                    $maxDate = date_create($teacher->currentSubscription()->expires);
                    $randomCreationTime = $minDate
                        ->addDays(rand(1,28))
                        ->addHours(rand(0,23))
                        ->addMinutes(rand(0,59))
                        ->addSeconds(rand(0,59));
                    $randomCreationTime = min($randomCreationTime, $maxDate);
                    $mark = rand(1,10) < 3;
                    if ($mark) {
                        $randomMarkedTime = $randomCreationTime
                        ->addDays(rand(1,28))
                        ->addHours(rand(0,23))
                        ->addMinutes(rand(0,59))
                        ->addSeconds(rand(0,59));
                        $randomMarkedTime = min($randomMarkedTime , $maxDate);
                    }
                    
                    $rows[] = [
                        'course_id' => $chosenCourse['id'],
                        'student_id'=> $student['id'],
                        'created_at' => $randomCreationTime,
                        'marked_at' => $mark ? $randomMarkedTime : null,
                        'updated_at' => $mark ? $randomMarkedTime : null,
                        'final_mark' => $mark ? rand(10,100) : null,
                    ];
                }
            }

            //insert into table
            DB::table('enrolments')->insert($rows);
            $rows = [];
            unset($rows);
        
        }
    }
}
