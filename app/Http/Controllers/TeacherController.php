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

    /**
     * Show confirmation page to delete account
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherConfirmDelete(){
        $this->authorize('teacherShow', Teacher::class);
        
        $message = "<p>You have chosen to delete your account.</p>";
        $message .= "<p>Please be aware that this will remove all of your data data, such as courses, chapters, assignments, students submissions, marks, etc.</p>";
        $message .= "<p>This action cannot be undone.</p>";
        $message .= "<p>Are you sure you want to delete ?</p>";
        return view('teacher.confirmDelete', [
            'route'=> route('teacher_teacherDelete'),
            'message'=>$message,
            'resource'=>'Account',
            'backRoute'=> route('teacher_account'),
        ]);
    }

    /**
     * Remove personnal information from teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherDelete(){
        $this->authorize('teacherShow', Teacher::class);
        //remove firstname, lastname, email, password    
        $userId = Auth::id();
        $teacher = Teacher::find($userId);
        $teacher->firstname = 'firstname_'.$userId;
        $teacher->lastname = 'lastname_'.$userId;
        $teacher->email = 'email_'.$userId;
        $teacher->save();
        $teacher->delete();
        Auth::logout();
        return redirect(route('welcome'));
    }
}
