<?php

namespace App\Policies;

use App\Models\StudentAssignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class SubmissionPolicy
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
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function studentAddQuestion(User $user, Submission $submission)
    {
        //submission belongs to student, and student assignment has not been marked yet
        return $submission->studentAssignment->enrolment->student_id == $user->id &&  $submission->studentAssignment->mark == null && $submission->question == null;
    }

    /**
     * Determine whether the student can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $assignment)
    {   
        
        //check student is enroled in this course
        $enrolment = DB::table('enrolments')->where('course_id', $assignment->course_id)->where('student_id', $user->id)->first();
        if(empty($enrolment)) return false;
        $studentAssignment = StudentAssignment::where('assignment_id', $assignment->id)->where('enrolment_id', $enrolment->id)->first();
        return (!$studentAssignment || count($studentAssignment->submissions) < $assignment->nb_submissions) && (date_create_from_format('d/m/Y H:i',$assignment->start_time) < now() && date_create_from_format('d/m/Y H:i',$assignment->end_time) >= now());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Submission $submission)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Submission $submission)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Submission $submission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Submission $submission)
    {
        //
    }
}
