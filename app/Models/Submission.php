<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $table = 'submissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_assignment_id',
        'content',
        'status',
        'feedback'
    ];

    public $timestamps = true;

    public function studentAssignment(){
        return $this->belongsTo('student_assignment', 'student_assignment_id', 'id');
    }
}
