<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\StudentAssignment;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class StudentAssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

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
        return !empty($enrolment) && (date_create_from_format('d/m/Y H:i',$assignment->start_time) < now() && date_create_from_format('d/m/Y H:i',$assignment->end_time) >= now());
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
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

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentAssignment  $studentAssignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, StudentAssignment $studentAssignment)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentAssignment  $studentAssignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, StudentAssignment $studentAssignment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentAssignment  $studentAssignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, StudentAssignment $studentAssignment)
    {
        //
    }
}
