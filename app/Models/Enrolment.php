<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrolment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'enrolments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'student_id',
        'final_mark',
        'marked_at'
    ];

    public $timestamps = true;

    /**
     * The course associated to this enrolment
     */
    protected function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    /**
     * The student associated to this enrolment
     */
    protected function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    
    protected function studentSkills(){
        return $this->hasMany(Skill::class, 'skill_id', 'id');
    }
}
