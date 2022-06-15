<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Enrolment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherViewAny(User $user)
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherView(User $user, Student $student)
    {
        return $student!=null && $user->isTeacher() && Teacher::find($user->id)->students->contains($student);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function studentShow(User $user)
    {
        return $user!=null && $user->isStudent();
    }

    /**
     * Determine whether the user view overall progress
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function studentProgress(User $user)
    {
        return $user->isStudent() && count(Student::find($user->id)->courses)!=0;
    }

    /**
     * Determine whether the teacher can soft delete the student enrolments.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Student $student)
    {
        return $student!=null && $user->isTeacher() && Teacher::find($user->id)->students->contains($student);
    }

    /**
     * Determine whether the teacher can create a new enrolment
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @param \App\Models\Course  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function teacherAddEnrolment(User $user, Student $student, Course $course){
        $previousEnrolment = Enrolment::where('student_id', $student->id)->where('course_id', $course->id)->count();
        return $user->isTeacher() && Teacher::find($user->id)->students->contains($student)
            && $previousEnrolment==0 && $course->teacher_id==$user->id;
    }

}
