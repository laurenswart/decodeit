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
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user,  $assignment)
    {
        return $user->isTeacher() && $assignment!=null && Teacher::find($user->id)->courses->contains($assignment->course);
    }
}
