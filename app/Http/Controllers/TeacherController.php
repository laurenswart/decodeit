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
    public function dashboard(){
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

    /**
     * Show account details for the teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function account(){
        $this->authorize('teacherShow', Teacher::class);
        $plan = Teacher::find(Auth::id())->currentSubscriptionPlan();

        $subscription = Teacher::find(Auth::id())->currentSubscription();
        return view('teacher.account', [
            'plan' => $plan,
            'subscription' => $subscription,
            'teacher' => Teacher::find(Auth::id())
        ]);
    }

    /**
     * Show edit form for teacher details
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherEdit(){
        $this->authorize('teacherShow', Teacher::class);
        $teacher = Teacher::find(Auth::id());
        

        return view('teacher.account_edit', [
            'teacher'=>$teacher
        ]);
    }

    /**
     * Update teacher details
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function teacherUpdate(Request $request){
        $this->authorize('teacherShow', Teacher::class);
        $teacher = Teacher::find(Auth::id());
        
        $rules = [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
        ];
        $validated = $request->validate($rules);

        $teacher->firstname = $validated['firstname'];
        $teacher->lastname = $validated['lastname'];
        $teacher->save();
        
        return  redirect(route('teacher_account'));
    }

}
