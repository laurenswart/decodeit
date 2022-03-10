<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChapterSeeder extends Seeder
{
    const TITLES = [
        'Débuggage',
        'Types de données',
        'Syntaxe du language',
        'Créer un premier script',
        'Bonnes pratiques',
        'Conditions if/else',
        'Les Boucles',
        'Manipulation de tableaux',
        'Dates et Heures',
        'Comment appliquer du style',
        'Les Chaines de caractères',
        'Opérations sur différents types de données',
        'Manipulation de tableaux',
        'Dates et Heures',
        'Comment appliquer du style',
        'Optimisations de code',
        'Implémentation de tests',
        'Structurer son projet',
        'Versionnage'
    ];
    const TITLES_INTRO = [
        'Introduction',
        'Notions de base',
        'Présentation du cours',
        'Chapitre I'
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
        Chapter::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //find teachers
        $teachers = Teacher::all();

        foreach($teachers as $teacher){
            
            //get the current subscription max number of chapters per lesson
            if(empty($teacher->currentSubscription())) continue;
            $nbChaptersMax = $teacher->currentSubscription()->nb_chapters;
            //get the courses by that teacher
            $courses = $teacher->courses;

            foreach($courses as $course){
                $nbChaptersToAdd= rand(0, $nbChaptersMax);
                if($nbChaptersToAdd==0) continue;
                //choose an intro chapter
                $titles[] = self::TITLES_INTRO[array_rand(self::TITLES_INTRO, 1)];
                $nbChaptersToAdd -= 1;
                //choose extra chapters
                if($nbChaptersToAdd > 0 ){
                    $nbChaptersToAdd = min(count(self::TITLES), $nbChaptersToAdd);
                    $titleIdsToAdd = array_rand(self::TITLES,$nbChaptersToAdd);
                    $titleIdsToAdd = is_int($titleIdsToAdd) ? [$titleIdsToAdd] : $titleIdsToAdd;
                    foreach($titleIdsToAdd as $titleIdToAdd){
                        $titles[] = self::TITLES[$titleIdToAdd];
                    }
                }
            
                //prepare chapters for that course
                foreach($titles as $index=>$title){
                    $extraTime = rand(60, (4*24*3600));
                    $rows[] = [
                        'course_ref'=>$course->course_id,
                        'title'=>$title,
                        'content'=> null,
                        'is_active'=> (rand(0,10)<8),
                        'order_id' => $index, 
                        'created_at' => date( 'Y-m-d H:i:s', $course->created_at->timestamp+$extraTime), 
                        'updated_at' => ( rand(0,10)<3 ?  date( 'Y-m-d H:i:s', $course->created_at->timestamp+$extraTime) : null), 
                    ];
                }
                //insert into table
                DB::table('chapters')->insert($rows);
                unset($rows);
            }
            
        }
        
    }
}
