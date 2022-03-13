<?php

namespace Database\Seeders;

use App\Models\Enrolment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ChaptersReadSeeder extends Seeder
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
        DB::table('chapters_read')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //find enrolments
        $enrolments = Enrolment::all();
        $rows = [];
        foreach($enrolments as $enrolment){
            //get the chapters in that course
            $chapters = $enrolment->course->chapters->where('is_active', 1)->toArray();
            $nbChaptersRead = rand(0, count($chapters));
            if($nbChaptersRead==0) continue;
            //mark some chapters as read
            $chaptersRead = Arr::random($chapters, $nbChaptersRead);
            foreach($chaptersRead as $chapterRead){
                $randomTime = now()
                    ->subMonths(3)
                    ->addDays(rand(1,26))
                    ->addHours(rand(0,23))
                    ->addMinutes(rand(0,59))
                    ->addSeconds(rand(0,59));
                $rows[] = [
                    'enrolment_ref'=>$enrolment->enrolment_id,
                    'chapter_ref'=>$chapterRead['chapter_id'],
                    'read_at'=> $randomTime,
                ];
            }
           
        }
        //insert into table
        DB::table('chapters_read')->insert($rows);
    }
}
