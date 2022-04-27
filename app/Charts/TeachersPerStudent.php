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
        $teachersPerStudent = DB::table('teacher_student')
            ->select(DB::raw('student_id, count(*) as nbTeachers'))
            ->groupBy('student_id')
            ->orderBy('nbTeachers')
            ->pluck('nbTeachers');


        $data = [];
        foreach ($teachersPerStudent as  $value) {
            //seperate into teacher/student
            $data[$value] = isset($data[$value]) ? ($data[ $value] + 1) : 1;
        }

        return Chartisan::build()
            ->labels(array_keys($data))
            ->dataset('', array_values($data));
    }
}