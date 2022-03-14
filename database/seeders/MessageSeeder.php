<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '2048M');
        //Empty the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Message::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //choose a course
        $courses = Course::all();

        foreach($courses as $course){
            $nbStudents = $course->students->count();
            //var_dump($course->students);
            if($nbStudents==0) continue;

            $users = $course->students->random(rand(0, $nbStudents));
            $users[] = $course->teacher;

            foreach($users as $user){
                $nbMessages = rand(1,3);
                Message::factory()->count($nbMessages)->create([
                    'user_ref'=>$user->user_id,
                    'course_ref'=>$course->course_id,
                ]);
            }
        }
    }
}
