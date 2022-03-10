<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $primaryKey = 'course_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_ref',
        'title',
        'is_active',
    ];

    public $timestamps = true;

    protected function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_ref', 'user_id' );
    }

    protected function chapters(){
        return $this->hasMany(Chapter::class, 'course_ref', 'course_id' );
    }
    protected function skills(){
        return $this->hasMany(Skill::class, 'course_ref', 'course_id' );
    }

    protected function messages(){
        return $this->hasMany(Message::class, 'course_id', 'course_ref' );
    }

    protected function students(){
        return $this->belongsToMany(Course::class, 'users', 'course_ref', 'student_ref', 'course_id', 'user_id');
    }
}
