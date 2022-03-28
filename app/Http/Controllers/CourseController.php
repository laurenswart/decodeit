<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    

    public function studentCourses(){
        $this->authorize('viewAny', Course::class);
        
        $courses = Student::find(Auth::id())->courses
            ->whereNull('deleted_at');

        
        $assignments = Assignment::all()
            ->sortBy('start_time')
            ->sortBy('end_time')
            ->whereIn('course_ref', $courses->pluck('course_id'));

        return view('student.courses', [
            'courses'=>$courses,
            'assignments'=>$assignments
        ]);
    }

    public function studentCourse($id){
        Gate::authorize('view-course', $id);

        $course = Course::find($id);

        $assignments = Assignment::all()
            ->sortBy('start_time')
            ->sortBy('end_time')
            ->where('course_ref', $id)
        ;

        return view('student.course', [
            'course'=>$course,
            'assignments'=>$assignments
        ]);
    }

    public function update(Request $request, Course $course){
        $this->authorize('update', $course);
 
        // The current user can update the course...
    }

    public function create(Request $request){
        $this->authorize('create', Course::class);
    
        // The current user can create blog posts...
    }
}
