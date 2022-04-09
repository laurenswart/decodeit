<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherStudentSeeder extends Seeder
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
        DB::table('teacher_student')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // //get students and teachers
        // $teachers = Teacher::get();
        // $students = Student::get();
        
        // //add lswart as student of bobsull
        // $testStudent = User::whereEmail('lswart@gmail.com')->first();
        // $testTeacher = User::whereEmail('bsull@gmail.com')->first();
        // $rows[] = ['student_id'=>$testStudent->id, 'teacher_id'=>$testTeacher->id];

        // //add students to teachers
        // foreach($teachers as $teacher){
        //     //find max number of students for this teacher
        //     $subscription = $teacher->currentSubscription();
        //     if(empty($subscription)) continue;
        //     $max_students = $subscription->nb_students;
        //     //choose a random amount of students within range
        //     $nbStudents = rand(0,$max_students);
        //     if($nbStudents==0) continue;
        //     $chosenStudents = $students->random($nbStudents)->toArray();
        //     //add to db
        //     //$teacher->students()->sync($chosenStudentIds); // array of student ids  
        //     foreach($chosenStudents as $chosenStudent){
        //         if($chosenStudent['email']!='lswart@gmail.com' || $teacher['email']!='bsull@gmail.com'){
        //             $rows[] = [
        //                 'student_id'=>$chosenStudent['id'], 
        //                 'teacher_id'=>$teacher['id']
        //             ];
        //         }
        //     } 
        // }

        // //insert into table
        // DB::table('teacher_student')->insert($rows);
    }
}
