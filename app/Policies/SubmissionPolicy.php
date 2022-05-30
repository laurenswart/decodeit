<?php

namespace App\Policies;

use App\Models\StudentAssignment;
use App\Models\Submission;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class SubmissionPolicy
{
    use HandlesAuthorization;

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
        return $submission->studentAssignment->enrolment->student_id == $user->id 
                &&  $submission->studentAssignment->mark == null 
                && $submission->question == null
                && $submission->studentAssignment->assignment->chapters[0]->is_active
                && $submission->studentAssignment->assignment->course->is_active;
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
        $enrolment = DB::table('enrolments')
            ->where('course_id', $assignment->course_id)
            ->where('student_id', $user->id)
            ->first();
        if(empty($enrolment)) return false;
        $studentAssignment = StudentAssignment::where('assignment_id', $assignment->id)
            ->where('enrolment_id', $enrolment->id)
            ->first();
        //student has at least 1 available submission remaining 
        //and the current date is between the start and end time for this assignment
        return (!$studentAssignment || count($studentAssignment->submissions) < $assignment->nb_submissions) 
                && $assignment->isOpen()  && $assignment->chapters[0]->is_active && $assignment->course->is_active;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherUpdate(User $user, Submission $submission)
    {
        
        return $submission!=null && $user->isTeacher() && Teacher::find($user->id)->courses->contains($submission->studentAssignment->assignment->course);
    }

}
