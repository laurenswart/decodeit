<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view a forum
     *
     * @param  \App\Models\User  $user
     * @param Course $course Course of the forum
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function studentForum(User $user, $course)
    {
        return !empty($course) && $user->isStudent() && Student::find($user->id)->courses->contains($course);
    }

    /**
     * Determine whether the user can view a forum
     *
     * @param  \App\Models\User  $user
     * @param Course $course Course of the forum
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherForum(User $user, $course)
    {
       
        return !empty($course) && $user->isTeacher() && $user->id == $course->teacher_id;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $course)
    {
        return !empty($course) && 
        (($user->isStudent() && Student::find($user->id)->courses->contains($course)) 
            || 
            $user->isTeacher() && $user->id == $course->teacher_id
        );
    }
}
