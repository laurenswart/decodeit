<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Show dashboard for the authenticated teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('teacher.dashboard', [
            'teacher' => Teacher::find(Auth::id())
        ]);
    }

    /**
     * Show teachers for the authenticated admin
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(){
        $teachers = Teacher::all();
        return view('admin.teacher.index', [
            'teachers'=>$teachers
        ]);
    }

    
    public function account(){
        $plan = Teacher::find(Auth::id())->currentSubscriptionPlan();

        $subscription = Teacher::find(Auth::id())->currentSubscription();
        return view('teacher.account', [
            'plan' => $plan,
            'subscription' => $subscription
        ]);
    }

}
