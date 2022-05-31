<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Chapter;
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        Chapter::truncate();
        Assignment::truncate();
        DB::table('assignment_chapter')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //CREATING RANDOM COURSES FOR SOME TEACHERS

        //teachers other than bob sull
        $teachers = Teacher::where('email', '!=', 'bsull@gmail.com')->get();
        foreach($teachers as $teacher){
            //find max number of courses for this teacher's subscription
            $subscription = $teacher->currentSubscriptionPlan();
            if(empty($subscription)) continue;
            $max_courses = $subscription->nb_courses;
            //choose a random amount of courses within range
            $nbCourses = rand(1,$max_courses);
            if($nbCourses==0) continue;
            //create the courses
            $courseTitles = array_rand(self::TITLES, $nbCourses);
            $courseTitles = is_int($courseTitles) ? [$courseTitles] : $courseTitles;
            foreach($courseTitles as $title){
                //course code
                $code = strtoupper(substr(md5(uniqid(mt_rand(), true)) , 0, 5));
                Course::factory()->create([
                    'teacher_id' => $teacher->id,
                    'title'=>$code.' '.self::TITLES[$title]
                ]);
            }
            
        }
        
        //CREATE PROPER COURSES FOR BOB SULL
        //create some proper courses for bob sull
        $bob = Teacher::firstWhere('email', '=', 'bsull@gmail.com');

        //get courses, ie folders in resources/courses
        $courses = Storage::disk('local')->directories('courses');
        $subscription = $bob->currentSubscriptionPlan();
        //foreach course, 
        foreach($courses as $coursePath){
            $courseName = explode('/',$coursePath)[1];
            //create the course
            $newCourse = Course::factory()->create([
                'teacher_id' => $bob->id,
                'title'=>$courseName,
                'is_active'=>1,
            ]);

            //create chapters
            $chapters = Storage::disk('local')->files($coursePath.'/chapters');
            foreach($chapters as $chapterPath){
                $chapterFullName = explode('chapters/',$chapterPath)[1];
                $bits = explode('-',$chapterFullName);
                $chapterOrderId = $bits[0];
                $chapterName = explode('.',$bits[1])[0];
                $newChapter = Chapter::factory()->create([
                    'course_id' => $newCourse->id,
                    'title'=>$chapterName,
                    'content'=>Storage::disk('local')->get($chapterPath),
                    'is_active'=>1,
                    'order_id'=>$chapterOrderId,
                ]);
            }
            //create assignments
            $assignments = Storage::disk('local')->files($coursePath.'/assignments');
            foreach($assignments as $assignmentPath){
                $assignmentFullName = explode('assignments/',$assignmentPath)[1];
                $bits = explode('-',$assignmentFullName);
                $chapterOrderId = $bits[0];
                $assignmentName =  explode('.',$bits[2])[0];
                $language = stripos('javascript', $courseName)!=-1 
                    ? 'javascript'
                    : (stripos('php', $courseName)!=-1 
                    ? 'php'
                    : (stripos('java', $courseName)!=-1 
                    ? 'java'
                    : (stripos('python', $courseName)!=-1
                    ? 'python'
                    : null)));
                $newAssignment = Assignment::factory()->create([
                    'course_id' => $newCourse->id,
                    'title' => $assignmentName,
                    'description' => Storage::disk('local')->get($assignmentPath),
                    'nb_submissions' => rand(1,$subscription->nb_submissions),
                    'test_script' => null,
                    'can_execute' => !empty($language),
                    'submission_size' => $subscription->max_upload_size,
                    'language' => $language
                ]);
                //set related chapter
                $chapter = Chapter::where('course_id',$newCourse->id)->firstWhere('order_id', $chapterOrderId);
                DB::table('assignment_chapter')->insert([
                    'assignment_id' => $newAssignment->id,
                    'chapter_id' => $chapter->id,
                ]);
            }
        }

    }

    
}
