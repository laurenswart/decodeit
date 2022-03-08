<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
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

        //get students and teachers
        $teachers = Teacher::get();
        $students = Student::get();

        foreach($students as $student){
            //choose number of teachers
            $nbTeachers = rand(0,4);
            if($nbTeachers==0) continue;
            //choose each teacher
            $chosenTeachers = $teachers->random($nbTeachers);
            foreach($chosenTeachers as $chosenTeacher){
                if($student['email']!='lswart@gmail.com' || $chosenTeacher['email']!='bsull@gmail.com'){
                    $rows[] = ['student_ref'=>$student['user_id'], 'teacher_ref'=>$chosenTeacher['user_id']];
                }
            }
            
        }

        //add lswart as student of bobsull if not already
        $testStudent = User::whereEmail('lswart@gmail.com')->first();
        $testTeacher = User::whereEmail('bsull@gmail.com')->first();
        $rows[] = ['student_ref'=>$testStudent['user_id'], 'teacher_ref'=>$testTeacher['user_id']];

        //insert into table
        DB::table('teacher_student')->insert($rows);
    }
}
