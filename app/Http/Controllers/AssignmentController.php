<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use App\Models\Chapter;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Show an assignment for the authenticated student
     *
     * @param int $id Id of the assignment
     * @return \Illuminate\Http\Response
     */
    public function studentShow($id){
        $assignment = Assignment::find($id);

        $this->authorize('studentView', $assignment);
    
        return view('student.assignment', [
            'assignment'=>$assignment,
        ]);
    }

    /**
     * Show form to create a new assignment
     *
     * @param int $id Chapter id
     * @return \Illuminate\Http\Response
     */
    public function teacherCreate(int $id){
        
        //if no more available chapters in subscription
        $teacher = Teacher::find(Auth::id());
        $chapter = Chapter::find($id);
        //dd($chapter->course->teacher_id);

        $this->authorize('create',  [Assignment::class, $chapter]);
        $plan = $teacher->currentSubscriptionPlan();
         
        if ($plan === null){
            return redirect( route('chapter_teacherShow', $id)) 
                ->with('flash_modal', 'You do not have an active subscription. Please choose one of our subscription plans, or renew your previous subscription.');
        } else if (count($chapter->course->assignments) >=  $plan->nb_assignments){
            return redirect( route('course_teacherShow', $id))
                ->with('flash_modal', 'You have reached your subscription limit! Please upgrade to a subscription with a higher number of assignments allowed, or delete one of your current assignments.
                    Please be aware that this will remove all associated data, such as student attempts, marks, etc.');
        }
        return view('teacher.assignment.create', ['chapter'=>$chapter]);
    }

    /**
     * Save new assignment
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id Chapter id
     * 
     * @return \Illuminate\Http\Response
     */
    public function teacherStore(Request $request, int $id){
        
    }
}
