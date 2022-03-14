<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
