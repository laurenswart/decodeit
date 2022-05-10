<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\StudentAssignment;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Show dashboard for the authenticated teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $teacher = Teacher::find(Auth::id());

        return view('teacher.dashboard', [
            'teacher' => Teacher::find(Auth::id()),
            'notifications'=> $teacher->notifications()
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
