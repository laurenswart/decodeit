<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Student;
use App\Models\StudentSkill;
use Exception;
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


    /**
     * Show form to update mark
     * 
     * @param int $studentId Id of the student
     * @param int $skillId Id of the skill
     */
    public function editStudentMark($studentId, $skillId){
        $skill = Skill::find($skillId);
        $student = Student::find($studentId);
        $assignments = $skill->assignments ?? [];

        $this->authorize('editStudentMark', [$skill, $student]);

        return view('teacher.student.skill', [
            'skill' => $skill,
            'student' => $student,
            'currentMark' => $skill->studentMark($studentId),
            'assignments' => $assignments
        ]);
    }

    /**
     * Update the mark if the row exists, create the row if not
     * 
     * @param Request $request
     * @param int $studentId Id of the student
     * @param int $skillId Id of the skill
     */
    public function updateStudentMark(Request $request, $studentId, $skillId){
        $skill = Skill::find($skillId);
        $student = Student::find($studentId);

        $this->authorize('editStudentMark', [$skill, $student]);

        //validate inputs
        $rules = [
            'mark' => "required|int|min:0|max:100",
        ];

        
        $validated = $request->validate($rules);

        //check if row exists in studentMark
       
        $row = StudentSkill::firstOrCreate([
            'skill_id' =>  $skillId,
            'enrolment_id' =>  $skill->course->enrolmentIdForStudent($studentId),
            
        ]);
        
        //update
        //$skill->course->enrolmentForStudent($studentId)->skills()->updateExistingPivot(null, array('mark' => $validated['mark']), false);
        $row->mark = $validated['mark'];
        $row->save();
        if($row->wasChanged('mark')){
            return redirect(route('student_teacherShow', $studentId));
        } else {
            return redirect(route('student_teacherShow', $studentId))->with('error', 'Sorry, something went wrong');
        }
    }
}
