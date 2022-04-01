<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show current users for the authenticated admin
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show deleted users for the authenticated admin
     *
     * @param int $id Id of the subscription
     * @return \Illuminate\Http\Response
     */
    public function adminDeletedAccounts(){
        $users = User::all()->whereNotNull('deleted_at');
        return view('admin.user.deleted', [
            'users'=>$users
        ]);
    }
}
