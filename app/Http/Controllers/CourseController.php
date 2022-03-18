<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    

    public function studentCourses(){

        
        $courses = Student::find(Auth::id())->courses
            ->whereNull('deleted_at');

        $assignments = DB::table('assignments')
            ->orderBy('start_time')
            ->orderBy('end_time')
            ->whereIn('course_ref', $courses->pluck('course_id'))
            ->get()
            ;

        
        return view('student.courses', [
            'courses'=>$courses,
            'assignments'=>$assignments
        ]);
    }

    public function studentCourse($id){
        $course = Course::find($id);

        $assignments = DB::table('assignments')
            ->orderBy('start_time')
            ->orderBy('end_time')
            ->where('course_ref', $id)
            ->get()
        ;
        
        return view('student.course', [
            'course'=>$course,
            'assignments'=>$assignments
        ]);
    }
}
