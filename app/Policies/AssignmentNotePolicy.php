<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentNotePolicy
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
     * @param  \App\Models\AssignmentNote  $assignmentNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AssignmentNote $assignmentNote)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user,  $assignment)
    {
        return $user->isTeacher() && $assignment!=null && Teacher::find($user->id)->courses->contains($assignment->course);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AssignmentNote  $assignmentNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AssignmentNote $assignmentNote)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AssignmentNote  $assignmentNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AssignmentNote $assignmentNote)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AssignmentNote  $assignmentNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AssignmentNote $assignmentNote)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AssignmentNote  $assignmentNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AssignmentNote $assignmentNote)
    {
        //
    }
}
