<?php

namespace App\Models;

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

    public function assignment(){
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }

    public function submissions(){
        return $this->hasMany(Submission::class, 'student_assignment_id', 'id');
    }

    public function enrolment(){
        return $this->belongsTo(Enrolment::class, 'enrolment_id', 'id');
    }

    
}
