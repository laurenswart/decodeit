<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentSeeder extends Seeder
{

    const LANGUAGES = [
        'php', 
        'javascript', 
        'python', 
        'java'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Assignment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        ini_set('memory_limit','256M');
        //the second chapter (if exists) of each course will have an assignment
        $chapters = Chapter::all()->where('order_id', 2);
        foreach($chapters as $chapter){
            $currentSubscription = $chapter->course->teacher->currentSubscription();
            if(empty($currentSubscription)) continue;
            $start =$chapter->created_at->timestamp+rand(3600, 134525);
            $end = $start+rand(3600, 3600*24*5);
            $canExecute = (rand(0,10)<3);
            $language = $canExecute ? self::LANGUAGES[array_rand(self::LANGUAGES, 1)] : null;
            $rows[] = [
                'course_ref'=>$chapter->course->course_id,
                'title'=>'First assignment',
                'description'=>'Create a function square(x) which returns the square of x.<br>
                                Return false if x is not a number.',
                'nb_submissions'=>rand(1, $currentSubscription->nb_submissions),
                'test_script'=>'some test script here',
                'max_mark'=> rand(1,10)*10,
                'course_weight'=>rand(1,10)/10,
                'start_time'=>  date( 'Y-m-d H:i:s', $start),
                'end_time'=>  date( 'Y-m-d H:i:s', $end),
                'is_test' => (rand(0,10)<3), 
                'can_execute'=> $canExecute,
                'submission_size'=> $currentSubscription->max_upload_size,
                'language'=>$language,
                'created_at'=>  date( 'Y-m-d H:i:s', rand($chapter->created_at->timestamp , $start)),
            ];
        }

        DB::table('assignments')->insert($rows);
    }
}