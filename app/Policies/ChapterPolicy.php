<?php

namespace App\Policies;

use App\Models\Chapter;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ChapterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function StudentView(User $user, Chapter $chapter)
    {
        return $user->isStudent() && Student::find($user->id)->courses->contains($chapter->course);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherView(User $user, Chapter $chapter)
    {
        return $user->isTeacher() && $chapter->course->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $course)
    {
        return $user->isTeacher() && $course->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function store(User $user, $course)
    {
        $teacher = Teacher::find($user->id);
        $plan = $teacher->currentSubscriptionPlan();
                
        return $user->isTeacher() 
            && $plan !== null 
            && $course->teacher_id === $user->id 
            && count($course->chapters) <  $plan->nb_chapters;
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Chapter $chapter)
    {
        return $user->isTeacher() && $chapter->course->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Chapter $chapter)
    {
        return $user->isTeacher() && $chapter->course->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Chapter $chapter)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Chapter $chapter)
    {
        //
    }
}
