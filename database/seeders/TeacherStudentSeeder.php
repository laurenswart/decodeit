<?php

namespace Database\Seeders;

use App\Models\Payments;
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

        /*
        foreach($students as $student){
            
            
            //choose each teacher, making sure that teacher's class isn't full
            $teachersWithRoom = Teacher::
                select( 'users.user_id', 'users.email')
                ->withCount('students')
                ->join('payments', 'users.user_id', '=', 'payments.teacher_ref')
                ->where([
                    ['payments.start_date', '<=', now()],
                    ['payments.expires', '>=', now()],
                ])
                ->join('subscriptions', 'payments.subscription_ref', '=', 'subscriptions.subscription_id')
                ->having('students_count', '<', 'subscriptions.nb_students')
                ->get(); 
            //choose number of teachers
            $nbTeachers = rand(0,$teachersWithRoom->count());
            if($nbTeachers==0) continue;
            //choose the teachers
            $chosenTeachers = $teachersWithRoom->random($nbTeachers);
            foreach($chosenTeachers as $chosenTeacher){
                if($student['email']!='lswart@gmail.com' || $chosenTeacher['email']!='bsull@gmail.com'){
                    $rows[] = ['student_ref'=>$student['user_id'], 'teacher_ref'=>$chosenTeacher['user_id']];
                }
            }
            
        }
        */

        foreach($teachers as $teacher){
            //find max number of students for this teacher
            $subscription = Payments::where([
                    ['teacher_ref', '=', $teacher['user_id']],
                    ['start_date', '<=', now()],
                    ['expires', '>=', now()],
                ])
                ->join('subscriptions', 'payments.subscription_ref', '=', 'subscriptions.subscription_id')
                ->select('subscriptions.nb_students')
                ->get();
            ;
            if($subscription->empty()) continue;
            $max_students = $subscription['nb_students'];
            //choose a random amount of students within range
            $nbStudents = rand(0,$max_students);
            if($nbStudents==0) continue;
            $chosenStudentIds = $students->random($nbStudents)->lists('user_id')->toArray();
            //add to db
            $teacher->students()->sync($chosenStudentIds); // array of student ids
        }

        //add lswart as student of bobsull if not already
        $testStudent = User::whereEmail('lswart@gmail.com')->first();
        $testTeacher = User::whereEmail('bsull@gmail.com')->first();
        $rows[] = ['student_ref'=>$testStudent['user_id'], 'teacher_ref'=>$testTeacher['user_id']];

        //insert into table
        DB::table('teacher_student')->insert($rows);
    }
}
