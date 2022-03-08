<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends User
{
    use HasFactory;

    public function students(){
        return $this->belongsToMany(Student::class, 'teacher_student', 'user_id', 'user_id');
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleRef(1);
    }
}
