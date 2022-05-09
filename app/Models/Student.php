<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Student extends User
{
    use HasFactory;

    public function teachers(){
        return $this->belongsToMany(Student::class, 'teacher_student', 'student_id', 'teacher_id', 'id', 'id', );
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleId(2);
    }

    public function courses(){
        return $this->belongsToMany(Course::class, 'enrolments', 'student_id', 'course_id', 'id', 'id')
            ->withPivot('final_mark', 'created_at', 'deleted_at')
            ->whereNull('enrolments.deleted_at');
    }

    public function coursesForTeacher(){
        return $this->courses->where('teacher_id', Auth::id());
    }

   

}
