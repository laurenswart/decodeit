<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    use HasFactory;

    public $table="student_assignment";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enrolment_id',
        'assignment_id',
        'to_mark',
        'mark',
        'marked_at'
    ];


    /**
     * The assignment this studentAssignment belongs to
     */
    public function assignment(){
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }

    /**
     * The subsmissions related to this studentAssignment
     */
    public function submissions(){
        return $this->hasMany(Submission::class, 'student_assignment_id', 'id');
    }

    /**
     * The enrolment this studentAssignment belongs to
     */
    public function enrolment(){
        return $this->belongsTo(Enrolment::class, 'enrolment_id', 'id');
    }

    /**
     * Know whether or not this student assignment can be marked
     * 
     * @return Boolean True if student has marked this assignment as done, or if the end date as passed, or if the number of authorized submissions has been reached. False otherwise.
     */
    public function canBeMarked(){
        return $this->to_mark || Carbon::createFromFormat('Y-m-d H:i:s',$this->assignment->end_time)->lt(now()) || count($this->submissions)>=$this->assignment->nb_submissions;
    }

    
}
