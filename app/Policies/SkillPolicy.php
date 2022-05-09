<?php

namespace App\Policies;

use App\Models\Skill;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class SkillPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can edit
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function editStudentMark(User $user, Skill $skill, Student $student)
    {
        if(empty($skill) || empty($student)){
            return false;
        }
        //teacher owns this course and student is enrolled in this course
        return Auth::id()==$skill->course->teacher_id && !empty($skill->course->enrolmentForStudent($student->id));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Skill $skill)
    {
        //
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
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Skill $skill)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Skill $skill)
    {
        return $user->isTeacher() && $skill->course->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Skill $skill)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Skill $skill)
    {
        //
    }
}
