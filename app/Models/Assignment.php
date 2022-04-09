<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignments';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'nb_submissions',
        'test_script',
        'max_mark',
        'course_weight',
        'start_time',
        'end_time',
        'is_test', 
        'can_execute',
        'submission_size',
        'language',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;

    public function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function notes(){
        return $this->hasMany(AssignmentNote::class, 'assignment_id', 'id');
    }

    public function chapters(){
        return $this->belongsToMany(Chapter::class, 'assignment_chapter', 'assignment_id', 'chapter_id', 'id', 'id');
    }

    public function skills(){
        return $this->belongsToMany(Skill::class, 'assignment_skills', 'assignment_id', 'skill_id', 'id', 'id');
    }

    /**
     * returns not done, incomplete, done, marked 
     */
    public function statusForAuth(){
        $enrolmentId = $this->course->enrolmentForAuth();

        $attempt = DB::table('student_assignment')
            ->where('enrolment_id', $enrolmentId)
            ->where('assignment_id', $this->id)
            ->first();

        if (empty($attempt)){
            return 'to do';
        }
        if($attempt->to_mark === null){
            return 'incomplete';
        }
        if($attempt->mark === null){
            return 'done';
        }
        return 'marked';

    }
}
