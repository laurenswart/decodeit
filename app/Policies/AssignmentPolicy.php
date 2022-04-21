<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\Chapter;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function studentView(User $user, Assignment $assignment)
    {
        return $user->isStudent() && Student::find($user->id)->courses->contains($assignment->course);
    }

   /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $chapter)
    {
        return $user->isTeacher() && $chapter!=null && $chapter->course->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherView(User $user, Assignment $assignment)
    {
        return $user->isTeacher() && $assignment!=null && Teacher::find($user->id)->courses->contains($assignment->course);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function store(User $user, $chapter)
    {
        $teacher = Teacher::find($user->id);
        $plan = $teacher->currentSubscriptionPlan();
                
        return $user->isTeacher() 
            && $plan !== null 
            && $chapter!=null 
            && $chapter->course->teacher_id === $user->id 
            && count($chapter->course->assignments) <  $plan->nb_assignments;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Assignment $assignment)
    {
        return $user->isTeacher() && $assignment!=null && Teacher::find($user->id)->courses->contains($assignment->course);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Assignment $assignment)
    {
        return $user->isTeacher() && $assignment!=null && Teacher::find($user->id)->courses->contains($assignment->course);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Assignment $assignment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Assignment $assignment)
    {
        //
    }
}
