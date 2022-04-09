<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    const TITLES = [
        'Programmation orientée objet',
        'Initiation à la programmation',
        'Programmation et Algorithmique en Python',
        'Programmation en Java',
        'Programmation en C',
        'Introduction au C#',
        'Structures de données',
        'Complexité des algorithmes',
        'Python pour débutants',
        'PHP avancé',
        'Frameworks Front-End',
        'Découverte de React',
        'Programmation et Algorithmique I',
        'Programmation et Algorithmique II',
        'Programmation et Algorithmique III',
        'Sites Statiques - Niveau 1',
        'Sites Statiques - Niveau 2',
        'Sites Statiques - Niveau 3',
        'Programmez en PHP',
        'Bases de Haskell',
        'Javascript I',
        'Javascript II',
        'Javascript III',
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the table first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Course::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // //get students and teachers
        // $teachers = Teacher::get();

        //  //add students to teachers
        //  foreach($teachers as $teacher){
        //     //find max number of students for this teacher
        //     $subscription = $teacher->currentSubscriptionPlan();
        //     if(empty($subscription)) continue;
        //     $max_courses = $subscription->nb_courses;
        //     //choose a random amount of courses within range
        //     $nbCourses = rand(1,$max_courses);
        //     if($nbCourses==0) continue;
        //     //choose courses
        //     $courseTitles = array_rand(self::TITLES, $nbCourses);
        //     $courseTitles = is_int($courseTitles) ? [$courseTitles] : $courseTitles;
        //     //create the courses
        //     foreach($courseTitles as $title){
        //         //course code
        //         $code = strtoupper(substr(md5(uniqid(mt_rand(), true)) , 0, 5));
        //         Course::factory()->create([
        //             'teacher_id' => $teacher->id,
        //             'title'=>$code.' '.self::TITLES[$title]
        //         ]);
        //     }
            
        // }
    }

    
}
