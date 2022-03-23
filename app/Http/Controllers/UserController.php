<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function adminIndex(){
        $nbTeachers = Teacher::all()->whereNull('deleted_at')->count();
        $nbStudents = Student::all()->whereNull('deleted_at')->count();
        $nbDeletes = User::all()->whereNotNull('deleted_at')->count();
        return view('admin.user.index', [
            'nbTeachers'=>$nbTeachers,
            'nbStudents'=>$nbStudents,
            'nbDeletes'=>$nbDeletes,
        ]);
    }
}
