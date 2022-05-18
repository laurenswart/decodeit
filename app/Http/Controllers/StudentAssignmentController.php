<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use App\Models\Enrolment;
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

    /**
     * Show a student assignment
     *
     * @param int $id Assignment id
     * @return \Illuminate\Http\Response 
     */
    public function teacherShow($id){
        $studentAssignment = StudentAssignment::find($id);

        $this->authorize('teacherShow', $studentAssignment);


        return view('teacher.studentAssignment.show', [
            'studentAssignment' => $studentAssignment,
            'student'=>$studentAssignment->enrolment->student
        ]);
    }

    /**
     * Show form to update mark
     *
     * @param int $id StudentAssignment id
     * @return \Illuminate\Http\Response 
     */
    public function teacherEditMark($id){
        $studentAssignment = StudentAssignment::find($id);

        $this->authorize('teacherEdit', $studentAssignment);
        if(!$studentAssignment->canBeMarked()){
            return redirect(route('student_dashboard'))->with('flash_modal', "You cannot mark this assignment yet.<br>Either the end date has not been reached, or the student has not yet finished working on it.");
        }

        return view('teacher.studentAssignment.mark', [
            'studentAssignment' => $studentAssignment,
            'student'=>$studentAssignment->enrolment->student
        ]);
    }

    /**
     * Process form t update mark
     *
     * @param int $id StudentAssignment id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
     */
    public function teacherUpdateMark(Request $request, $id){
        $studentAssignment = StudentAssignment::find($id);

        $this->authorize('teacherUpdate', $studentAssignment);

        //validate inputs
        $rules = [
            'mark' => "required|int|min:0|max:".$studentAssignment->assignment->max_mark,
        ];

        
        $validated = $request->validate($rules);

        $studentAssignment->mark = $validated['mark'];
        $studentAssignment->marked_at = now();
        $studentAssignment->save();

        if($studentAssignment->wasChanged('mark')){
            return view('teacher.studentAssignment.show', [
                'studentAssignment' => $studentAssignment,
                'student'=>$studentAssignment->enrolment->student
                
            ]);
        } else {
            return view('teacher.studentAssignment.show', [
                'studentAssignment' => $studentAssignment,
                'student'=>$studentAssignment->enrolment->student
            ])->with('error', 'Sorry, something went wrong');
        }
    }

    public function teacherStore(int $assignmentId, int $studentId){
        $assignment = Assignment::find($assignmentId);
        $enrolment = Enrolment::
                whereNull('enrolments.deleted_at')
                ->where('student_id', $studentId)
                ->where('course_id', $assignment->course_id)
                ->first();
       // dd($enrolment);   
        $this->authorize('teacherStore', [StudentAssignment::class, $assignment,$enrolment]);

        //create the student assignment
        $studentAssignmentId = StudentAssignment::insertGetId([
            'enrolment_id'=>$enrolment->id,
            'assignment_id'=>$assignmentId,
        ]);
        //redirect
        return redirect(route('studentAssignment_teacherShow', $studentAssignmentId));
    }
}
