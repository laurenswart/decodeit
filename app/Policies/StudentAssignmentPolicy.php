<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrolment;
use App\Models\Student;
use App\Models\StudentAssignment;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class StudentAssignmentPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can mark the model as done.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function studentDone(User $user,  $assignment)
    {
        if(empty($assignment)) return false;
        //check student is enroled in this course
        $enrolment = DB::table('enrolments')->where('course_id', $assignment->course_id)->where('student_id', $user->id)->first();
        return !empty($enrolment) && $assignment->isOpen() && $assignment->chapters[0]->is_active && Course::find($enrolment->course_id)->is_active;
    }

    /**
     * Determine whether the teacher can automatically create a student assignment 
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @param  \App\Models\Enrolment  $enrolment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherStore(User $user, Assignment $assignment, Enrolment $enrolment)
    {
        return $user->isTeacher() && $assignment!=null && $enrolment!=null 
            && Teacher::find($user->id)->students->contains($enrolment->student) 
            && Teacher::find($user->id)->courses->contains($assignment->course)
            && strtotime($assignment->end_time) < now()->timestamp
            && StudentAssignment::where('enrolment_id', $enrolment->id)->where('assignment_id', $assignment->id)->count()==0;
    }

    /**
     * Determine whether the teacher can view a model.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherShow(User $user, StudentAssignment $studentAssignment)
    {
        return $user->isTeacher() && $studentAssignment!=null && Teacher::find($user->id)->students->contains($studentAssignment->enrolment->student) && Teacher::find($user->id)->courses->contains($studentAssignment->assignment->course);
    }

    /**
     * Determine whether the teacher can edit a model.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherEdit(User $user, StudentAssignment $studentAssignment)
    {
        return $user->isTeacher() && $studentAssignment!=null  && Teacher::find($user->id)->students->contains($studentAssignment->enrolment->student) && Teacher::find($user->id)->courses->contains($studentAssignment->assignment->course);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentAssignment  $studentAssignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherUpdate(User $user, StudentAssignment $studentAssignment)
    {
        return $user->isTeacher() && $studentAssignment!=null && $studentAssignment->canBeMarked() && Teacher::find($user->id)->students->contains($studentAssignment->enrolment->student) && Teacher::find($user->id)->courses->contains($studentAssignment->assignment->course);
    }
}
