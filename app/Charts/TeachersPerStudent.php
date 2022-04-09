<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeachersPerStudent extends BaseChart
{

    public ?string $routeName = 'teachersPerStudent';
    public ?array $middlewares = ['adminauth'];
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        //get number of users enrolled per month
        
        $teachersPerStudent = DB::table('teacher_student')
            ->select(DB::raw('student_id, count(*) as nbTeachers'))
            ->groupBy('student_id')
            ->orderBy('nbTeachers')
            ->pluck('nbTeachers');


        $data = [];
        foreach ($teachersPerStudent as  $value) {
            //seperate into teacher/student
            $data[$value.' teacher'] = isset($data[$value.' teacher']) ? ($data[$value.' teacher'] + 1) : 1;
        }
        
        $results = DB::select( DB::raw("
            select t2.nbTeachers , count(*) 'occurences'
            from
                (select count(*) 'nbTeachers'
                from enrolments
                group by student_id) as t2
            group by t2.nbTeachers
            order by t2.nbTeachers"));


        foreach ($results as  $row) {
            //seperate into teacher/student
            $data[] = $row->occurences;
            $labels[] = $row->nbTeachers;
        }

        return Chartisan::build()
            ->labels($labels)
            ->dataset('', $data);
    }
}