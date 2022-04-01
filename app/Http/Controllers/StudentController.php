<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Show dashboard for the authenticated student
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('student.dashboard');
    }

    /**
     * Show students for the authenticated admin
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(){
        $students = Student::all();
        return view('admin.student.index', [
            'students'=>$students
        ]);
    }

    /**
     * Show students for the authenticated teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherIndex(){
        $this->authorize('teacherViewAny', Student::class);

        $students = Teacher::find(Auth::id())->students;
        return view('teacher.students', [
            'students'=>$students
        ]);
    }
}
