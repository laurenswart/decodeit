<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use Illuminate\Http\Request;

class EnrolmentController extends Controller
{
    /**
     * Shows the confirmation page for deletion
     * 
     * @param int $id Chapter Id
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
     * Soft Deleted the chapter
     * 
     * @param int $id Chapter Id
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
}
