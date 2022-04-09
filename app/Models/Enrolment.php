<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    use HasFactory;

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

    
    protected function studentSkills(){
        return $this->hasMany(Skill::class, 'skill_id', 'id');
    }
}
