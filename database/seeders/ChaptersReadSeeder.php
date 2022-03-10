<?php

namespace Database\Seeders;

use App\Models\Enrolment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

        foreach($enrolments as $enrolment){
            //get the chapters in that course
            $chapters = $enrolment->course->chapters->where('is_active', 1)->toArray();
            $nbChaptersRead = rand(0, count($chapters));
            if($nbChaptersRead==0) continue;
            //mark some chapters as read
            $chaptersReadIds = array_rand($chapters, $nbChaptersRead);
            $chaptersReadIds = is_int($chaptersReadIds) ? [$chaptersReadIds] : $chaptersReadIds;
            foreach($chaptersReadIds as $chapterReadId){
                $extraTime = rand(10, (4*24*3600));
                $rows[] = [
                    'enrolment_ref'=>$enrolment->enrolment_id,
                    'chapter_ref'=>$chapters[$chapterReadId]['chapter_id'],
                    'read_at'=> date( 'Y-m-d H:i:s', strtotime(max($enrolment->created_at,$chapters[$chapterReadId]['created_at']))+$extraTime),
                ];
            }
            //insert into table
            DB::table('chapters_read')->insert($rows);
            $rows = [];
            unset($rows);
        }
        
    }
}
