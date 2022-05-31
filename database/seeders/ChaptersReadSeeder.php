<?php

namespace Database\Seeders;

use App\Models\Enrolment;
use App\Models\Student;
use App\Models\Teacher;
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
        ini_set('memory_limit', '2048M');
        //Empty the table first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('chapters_read')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //get enrolments
        $enrolments = Enrolment::all();
        foreach($enrolments as $enrolment){
            $rows = [];
            //get the chapters in that course
            $chapters = $enrolment->course->chapters->where('is_active', 1)->toArray();
            $nbChaptersRead = rand(0, count($chapters));
            if($nbChaptersRead==0) continue;
            //mark some chapters as read
            for($i=0; $i<$nbChaptersRead; $i++){
                $randomTime = now()
                    ->setHour(0)
                    ->subMonths(3)
                    ->addDays(rand(1,28))
                    ->addHours(rand(3,23))
                    ->addMinutes(rand(0,59))
                    ->addSeconds(rand(0,59));
                //dd($randomTime);
                //$randomTime = new \DateTime($randomTime, new \DateTimeZone('UTC'));
                $rows[] = [
                    'enrolment_id'=>$enrolment->id,
                    'chapter_id'=>$chapters[$i]['id'],
                    'read_at'=> $randomTime->format('Y-m-d H:i:s'),
                ];
            }
            //insert into table
            DB::table('chapters_read')->insert($rows);
        }
    }
}
