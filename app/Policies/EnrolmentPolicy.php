<?php

namespace App\Policies;

use App\Models\Enrolment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnrolmentPolicy
{
    use HandlesAuthorization;

    
  

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enrolment  $enrolment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Enrolment $enrolment)
    {
        return $user->isTeacher() && $enrolment!==null && $enrolment->course->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enrolment  $enrolment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Enrolment $enrolment)
    {
        return $user->isTeacher() && $enrolment->course->teacher_id === $user->id;
    }

}
