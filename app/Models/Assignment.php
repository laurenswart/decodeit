<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignments';

    protected $primaryKey = 'assignment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_ref',
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
        return $this->belongsTo(Course::class, 'course_ref', 'course_id');
    }

    public function notes(){
        return $this->hasMany(AssignmentNote::class, 'assignment_ref', 'assignment_id');
    }

    public function chapters(){
        return $this->belongsToMany(Chapter::class, 'assignment_chapter', 'assignment_ref', 'chapter_ref', 'assignment_id', 'chapter_id');
    }

    public function skills(){
        return $this->belongsToMany(Skill::class, 'assignment_skills', 'assignment_ref', 'skill_ref', 'assignment_id', 'skill_id');
    }

    /**
     * returns not done, incomplete, done, marked 
     */
    public function statusForAuth(){
        $enrolmentId = $this->course->enrolmentForAuth();

        $attempt = DB::table('student_assignment')
            ->where('enrolment_ref', $enrolmentId)
            ->where('assignment_ref', $this->assignment_id)
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
