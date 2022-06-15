<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
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
    public function adminIndex(Request $request){

        $currentQueries = $request->query();
        $sort = $request->query('sort') ?? 'firstname';
        $order = $request->query('order') ?? 'asc';
        $filter = $request->query('filter') ?? '';
        $teachers = Teacher::
                orderBy($sort, $order)
                ->where(function ($query) use ($filter){
                    $query->where('firstname', 'like', "%$filter%")
                          ->orWhere('lastname', 'like',"%$filter%");
                })
                ->paginate(10)
                ->appends( ['sort'=>$sort, 'order'=>$order, 'filter'=>$filter ]);
        
        $currentQueries['sort'] = $sort;
        $currentQueries['order'] = $order;
        $currentQueries['filter'] = $filter;
        return view('admin.teacher.index', [
            'teachers'=>$teachers,
            'currentQueries'=>$currentQueries
        ]);
    }

    /**
     * Show account details for the teacher
     *
     * @param int $id Teacher id
     * @return \Illuminate\Http\Response
     */
    public function adminShow(int $id ){
        $teacher = Teacher::find($id);
        $plan = $teacher->currentSubscriptionPlan();
        $subscription = $teacher->currentSubscription();
        $nbAssignments = Assignment::whereIn('course_id',$teacher->courses->pluck('id'))->count();
        return view('admin.teacher.show', [
            'plan' => $plan,
            'subscription' => $subscription,
            'teacher' => $teacher,
            'nbAssignments' => $nbAssignments
        ]);
    }

    /**
     * Show account details for the teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function account(){
        $this->authorize('teacherShow', Teacher::class);
        $teacher = Teacher::find(Auth::id());
        $plan = $teacher->currentSubscriptionPlan();
        $nbAssignments = Assignment::whereIn('course_id',$teacher->courses->pluck('id'))->count();
        $subscription = $teacher->currentSubscription();
        return view('teacher.account', [
            'plan' => $plan,
            'subscription' => $subscription,
            'teacher' => Teacher::find(Auth::id()),
            'nbAssignments' => $nbAssignments
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

        $userId = Auth::id();
        $teacher = Teacher::find($userId);
        //delete data on stripe
        if($teacher->stripe_id!=null){
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $stripe->customers->delete($teacher->stripe_id);
        }

        //remove firstname, lastname, email    
        $teacher->firstname = 'firstname_'.$userId;
        $teacher->stripe_id = null;
        $teacher->lastname = 'lastname_'.$userId;
        $teacher->email = 'email_'.$userId;
        $teacher->save();
        $teacher->delete();

        //delete teacher courses
        $teacher->courses()->delete();

dd('hi');
        Auth::logout();
        return redirect(route('welcome'));
    }
}
