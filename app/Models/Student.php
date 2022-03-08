<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends User
{
    use HasFactory;

    public function teachers(){
        return $this->belongsToMany(Teacher::class, 'teacher_student', 'user_id', 'user_id');
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleRef(2);
    }
}
