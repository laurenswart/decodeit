<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    
    /**
     * Show courses for the authenticated student
     *
     * @return \Illuminate\Http\Response
     */
    public function studentIndex(){
        $this->authorize('studentViewAny', Course::class);
        
        $courses = Student::find(Auth::id())->courses
            ->whereNull('deleted_at');

        $assignments = Assignment::all()
            ->sortBy('start_time')
            ->sortBy('end_time')
            ->whereIn('course_id', $courses->pluck('id'));

        return view('student.courses', [
            'courses'=>$courses,
            'assignments'=>$assignments
        ]);
    }

    /**
     * Show courses for the authenticated teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherIndex(){
        $this->authorize('teacherViewAny', Course::class);

        $courses = Teacher::find(Auth::id())->courses
            ->whereNull('deleted_at');

        return view('teacher.course.index', [
            'courses'=>$courses,
        ]);
    }


    /**
     * Show a course for the authenticated student
     *
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function studentShow($id){
        $course = Course::find($id);

        $this->authorize('studentView', $course);

        $assignments = Assignment::all()
            ->sortBy('start_time')
            ->sortBy('end_time')
            ->where('course_id', $id)
        ;

        return view('student.course', [
            'course'=>$course,
            'assignments'=>$assignments
        ]);
    }

    /**
     * Show a course for the authenticated teacher
     *
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function teacherShow($id){
        $course = Course::find($id);

        $this->authorize('teacherView', $course);

        $assignments = Assignment::all()
            ->sortBy('start_time')
            ->sortBy('end_time')
            ->where('course_id', $id)
        ;

        return view('teacher.course.show', [
            'course'=>$course,
            'assignments'=>$assignments
        ]);
    }

}
