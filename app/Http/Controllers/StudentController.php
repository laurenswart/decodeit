<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }
    */

    public function dashboard()
    {
        return view('student.dashboard');
    }

    public function adminIndex(){
        $students = Student::all();
        return view('admin.student.index', [
            'students'=>$students
        ]);
    }
}
