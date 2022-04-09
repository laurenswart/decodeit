<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected function courses(){
        return $this->belongsToMany(Course::class, 'enrolments', 'student_id', 'course_id', 'id', 'id');
    }

}
