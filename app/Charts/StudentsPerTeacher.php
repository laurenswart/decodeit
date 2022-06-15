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
     * Creates a Chart representing the number of students per teacher
     * 
     * @param Illuminate\Http\Request $request
     * @return Chartisan\PHP\Chartisan Chart
     */
    public function handler(Request $request): Chartisan
    {
        $studentsPerTeacher = DB::table('teacher_student')
            ->select(DB::raw('teacher_id, count(*) as nbStudents'))
            ->groupBy('teacher_id')
            ->orderBy('nbStudents')
            ->pluck('nbStudents');


        $data = [];
        //count nb of occurences of each value 
        foreach ($studentsPerTeacher as  $value) {
            $data[$value] = isset($data[$value]) ? ($data[ $value] + 1) : 1;
        }

        return Chartisan::build()
            ->labels(array_keys($data))
            ->dataset('', array_values($data));
    }
}