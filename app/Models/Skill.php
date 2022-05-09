<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Skill extends Model
{
    use HasFactory;

    protected $table = 'skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description'
    ];

    public $timestamps = false;

    /**
     * The course associated to this enrolment
     */
    protected function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }


    /**
     * The mark for a student for the skill
     * 
     * @param int $studentId Id of the student
     */
    public function studentMark($studentId){
        $student = Student::find($studentId);
        $course = Course::find($this->course->id);
        if (empty($student) || empty($course) || empty($course->enrolmentForStudent($student->id)->skills)){
            return false;
        }
        
        $pivotRow = $course->enrolmentForStudent($student->id)->skills()->wherePivot('skill_id',$this->id)->first();

        return !$pivotRow ? null :  $pivotRow->pivot->mark;
    }
}
