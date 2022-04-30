<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Student;
use App\Models\StudentAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentAssignmentController extends Controller
{

    /**
     * Send student to confirmation page
     *
     * @param int $id Assignment id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
     */
    public function studentConfirmDone($id){
        //get the student assignment
        $assignment = Assignment::find($id);
        if(empty($assignment)){
            return redirect(route('student_dashboard'))->with('flash_modal', "Sorry, we were unable to handle your request.");
        }
        //authorize action
        $this->authorize('studentDone', [StudentAssignment::class, $assignment]);

        return view('student.confirm', [
            'title' => 'Are you sure this assignment is done?',
            'message' => 'This action can not be undone. <br>Once an assignment is marked as done, you will no longer be able to send submissions.',
            'confirmAction'=> route('studentAssignment_studentDone', $id),
            'confirmLabel' => 'Assignment done',
            'backRoute' => route('assignment_studentShow', $id)
        ]);
    }
   
   /**
     * Mark a student assignment as done
     *
     * @param int $id Assignment id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
     */
    public function studentDone(Request $request, int $id){
        //get the student assignment
        $studentAssignment = Assignment::find($id)->studentAssignmentByStudent(Auth::id());
        $student = Student::find(Auth::id());
        $assignment = Assignment::find($id);

        //authorize action
        $this->authorize('studentDone', [StudentAssignment::class, $assignment]);

        
        if(empty($studentAssignment)){
            //create student assignment if doesn't exist
            $enrolment = DB::table('enrolments')->where('course_id', $assignment->course_id)->where('student_id', $student->id)->first();
            $studentAssignmentId = DB::table('student_assignment')->insertGetId([
                'enrolment_id' => $enrolment->id,
                'assignment_id' => $assignment->id,
                'to_mark'=> true,
            ]);
            $studentAssignment = DB::table('student_assignment')->find($studentAssignmentId);
        } else{
            $studentAssignment->to_mark = true;
            $studentAssignment->save();
        }

        return redirect(route('assignment_studentShow', $id));
    }
}
