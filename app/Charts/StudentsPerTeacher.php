<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Enrolment;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StudentsPerTeacher extends BaseChart
{

    public ?string $routeName = 'studentsPerTeacher';
    public ?array $middlewares = ['adminauth'];
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        //get number of users enrolled per month
        $studentsPerTeacher = DB::table('teacher_student')
            ->select(DB::raw('teacher_ref, count(*) as nbStudents'))
            ->groupBy('teacher_ref')
            ->orderBy('nbStudents')
            ->pluck('nbStudents');


        $data = [];
        foreach ($studentsPerTeacher as  $value) {
            //seperate into teacher/student
            $data[$value] = isset($data[$value]) ? ($data[ $value] + 1) : 1;
        }

        return Chartisan::build()
            ->labels(array_keys($data))
            ->dataset('', array_values($data));
    }
}