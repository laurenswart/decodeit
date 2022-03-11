<?php

namespace Database\Seeders;

use App\Models\Assignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentChapterSeeder extends Seeder
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
        DB::table('assignment_chapter')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //find assignments
        $assignments = Assignment::all();

        foreach($assignments as $assignment){
            
            //get the course it belongs to, and prepare assignment for chapter 2
            $course = $assignment->course;
            $chapterRef = $course->chapters->where('order_id', 2)->first()->chapter_id;
              
            $rows[] = [
                'chapter_ref'=>$chapterRef,
                'assignment_ref'=>$assignment->assignment_id,
            ];
        }
        DB::table('assignment_chapter')->insert($rows);
    }
}
