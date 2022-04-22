<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Shows the confirmation page for deletion
     * 
     * @param int $id Chapter Id
     * @return \Illuminate\Http\Response
     */
    public function teacherConfirmDelete($id){
        $skill = Skill::find($id);
        if(empty($skill)){
            return redirect(route('course_teacherIndex'))->with('flash_modal', "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $skill);
        $message = "<p>You have chosen to delete the following skill: <strong>".$skill->title."</strong></p>";
        $message .= "<ul><li>Course: ".$skill->course->title."</li></ul>";
        $message .= "<p>Please be aware that this will remove all associated data, such as marks, links to assignments, etc.</p>";
        $message .= "<p>Sure you want to delete ?</p>";
        return view('teacher.confirmDelete', [
            'route'=> route('skill_teacherDelete', $id),
            'message'=>$message,
            'backRoute'=> route('course_teacherShow', $skill->course->id),
            'resource'=>'skill'
        ]);
    }

    /**
     * Soft Deleted the chapter
     * 
     * @param int $id Chapter Id
     * @return \Illuminate\Http\Response
     */
    public function teacherDelete($id){
        $skill = Skill::find($id);
        if(empty($skill)){
            return redirect(route('course_teacherIndex'))->with("flash_modal", "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $skill);
        
        //delete the course and the enrolments
        $deleted = $skill->delete();
        if ($deleted){
            return redirect(route('course_teacherShow', $skill->course->id))->with('success', 'Skill Deleted');
        } else {
            return redirect(route('course_teacherShow', $skill->course->id))->with('error', 'Skill Could not be Deleted');
        }
    }
}
