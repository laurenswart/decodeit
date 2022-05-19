<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use Illuminate\Http\Request;

class EnrolmentController extends Controller
{
    /**
     * Shows the confirmation page for deletion
     * 
     * @param int $id Enrolment Id
     * @return \Illuminate\Http\Response
     */
    public function teacherConfirmDelete($id){
        $enrolment = Enrolment::find($id);
        if(empty($enrolment)){
            return redirect(route('course_teacherIndex'))->with('flash_modal', "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $enrolment);
        $message = "<p>You have chosen to delete a student from one of your courses: ";
        $message .= "<ul><li>Course: ".$enrolment->course->title."</li><li>Student: ".$enrolment->student->firstname." ".$enrolment->student->lastname."</li></ul>";
        $message .= "<p>Please be aware that this will remove all associated data, student attempts, marks, etc.</p>";
        $message .= "<p>Sure you want to delete ?</p>";
        return view('teacher.confirmDelete', [
            'route'=> route('enrolment_teacherDelete', $id),
            'message'=>$message,
            'backRoute'=> route('course_teacherShow', $enrolment->course_id),
            'resource'=>'enrolment'
        ]);
    }

    /**
     * Soft Deleted the enrolment
     * 
     * @param int $id Enrolment Id
     * @return \Illuminate\Http\Response
     */
    public function teacherDelete($id){
        $enrolment = Enrolment::find($id);
        if(empty($enrolment)){
            return redirect(route('course_teacherIndex'))->with("flash_modal", "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $enrolment);
        
        //delete the course and the enrolments
        $deleted = $enrolment->delete();
        if ($deleted){
            return redirect(route('course_teacherShow', $enrolment->course->id))->with('success', 'Enrolment Deleted');
        } else {
            return redirect(route('course_teacherShow', $enrolment->course->id))->with('error', 'Enrolment Could not be Deleted');
        }
    }

    /**
     * Display form to edit final mark
     * 
     * @param int $id Enrolment Id
     * @return \Illuminate\Http\Response
     */
    public function teacherEdit($id){
        $enrolment = Enrolment::find($id);
        if(empty($enrolment)){
            return redirect(route('course_teacherIndex'))->with("flash_modal", "Sorry, we were unable to handle your request.");
        }
        $this->authorize('update', $enrolment);
        $assignments = $enrolment->course->assignments;

        $markedStudentAssignments = $enrolment->student->studentAssignments->whereNotNull('mark');
        if(count($markedStudentAssignments)==0){
            $computation = false;
            $computedMark = false;
            $sumWeights = false;
        } else {
            $computedMark = 0;
            $sumWeights = 0;
            $computation = '';
            foreach($markedStudentAssignments as $markedStudentAssignment){
                $computationBits[] = $markedStudentAssignment->assignment->course_weight.' * <sup>'.$markedStudentAssignment->mark.'</sup>&frasl;<sub>'.$markedStudentAssignment->assignment->max_mark.'</sub>';
                
                $computedMark += $markedStudentAssignment->assignment->course_weight * $markedStudentAssignment->mark / $markedStudentAssignment->assignment->max_mark;
                $sumWeights += $markedStudentAssignment->assignment->course_weight;
            }
            if($sumWeights==0){
                $computation = implode(' + ', $computationBits);
                $computedMark = 0;
                
            } else {
                $computation = '<sup>1</sup>&frasl;<sub>'.$sumWeights.'</sub> * ('. implode(' + ', $computationBits).' ) * 100';
                $computedMark = $computedMark / $sumWeights * 100;
            }
           
            
        }
        

        return view('teacher.student.finalmark', [
            'assignments'=>$assignments,
            'enrolment'=>$enrolment,
            'computation'=>$computation, 
            'computedMark'=>$computedMark
        ]); 
    }

    /**
     * Update final mark
     * 
     * @param int $id Enrolment Id
     * @return \Illuminate\Http\Response
     */
    public function teacherUpdate(Request $request, $id){
        $enrolment = Enrolment::find($id);
        $this->authorize('update', $enrolment);

        $rules = [
            'mark' => "required|int|min:0|max:100",
        ];

        
        $validated = $request->validate($rules);

        $enrolment->final_mark = $validated['mark'];
        $enrolment->save();

        if($enrolment->wasChanged('final_mark')){
            return redirect(route('student_teacherShow', $enrolment->student_id));
        } else {
            return redirect(route('student_teacherShow', $enrolment->student_id))->with('error', 'The mark was not updated');
        }
    }
}
