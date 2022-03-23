<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }
    */
    
    public function dashboard()
    {
        return view('teacher.dashboard');
    }

    public function adminIndex(){
        $teachers = Teacher::all();
        return view('admin.teacher.index', [
            'teachers'=>$teachers
        ]);
    }
}
