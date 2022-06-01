<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

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

    public function studentAssignments(){
        return $this->hasMany(StudentAssignment::class, 'assignment_id', 'id');
    }

    public function chapters(){
        return $this->belongsToMany(Chapter::class, 'assignment_chapter', 'assignment_id', 'chapter_id', 'id', 'id');
    }

    public function skills(){
        return $this->belongsToMany(Skill::class, 'assignment_skills', 'assignment_id', 'skill_id', 'id', 'id');
    }

    
    public function studentAssignmentByStudent($studentId){
        $enrolment = Enrolment::where('course_id', $this->course_id)->where('student_id', $studentId)->first();
        
        return StudentAssignment::where('assignment_id', $this->id)->where('enrolment_id', $enrolment->id)->first();
    }

    /**
     * returns not done, incomplete, done, marked 
     */
    public function statusByStudent($studentId){
        $studentAssignment = $this->studentAssignmentByStudent($studentId);
        if(empty($studentAssignment)){
            return   $this->end_time_carbon()->lt(now()) 
            ? 'missed' 
            :( $this->start_time_carbon()->gt(now())
            ? 'unavailable'
            : 'to do'
            );
        }

        if($studentAssignment->mark!==null){
            return 'marked';
        } else if($this->start_time_carbon()->gt(now())){
            return 'unavailable';
        } else if($studentAssignment->to_mark || ($this->end_time_carbon()->lt(now()) && count($studentAssignment->submissions) > 0) || count($studentAssignment->submissions) >= $studentAssignment->assignment->nb_submissions){
            return 'done';
        } else if(count($studentAssignment->submissions) === 0 && $this->end_time_carbon()->gt(now())){
            return 'to do';
        } else if($this->end_time_carbon()->lt(now()) && count($studentAssignment->submissions) === 0){
            return 'missed';
        }
        return 'undergoing';
        
    }

    /**
     * returns not done, incomplete, done, marked as well as appropriate icon
     */
    public function statusTextByStudent($studentId){
        $text = $this->statusByStudent($studentId);
        $icon = null;
        switch($text){
            case 'to do':
                $icon = '<i class="fas fa-exclamation-square"></i>';
                break;
            case 'marked':
                $icon = '<i class="fas fa-check-double greyed no-hover"></i>';
                break;
            case 'done':
                $icon = '<i class="fas fa-check-square greyed no-hover"></i>';
                break;
            case 'undergoing':
                $icon = '<i class="fas fa-spinner"></i>';
                break;
            case 'missed':
                $icon = '<i class="fas fa-times-square greyed"></i>';
                break;
            case 'unavailable':
                $icon = '<i class="fas fa-times-square greyed"></i>';
                break;
            default:
                $icon = '<i class="fas fa-clipboard-list greyed"></i>';
        }
        return $icon.ucwords($text);
    }


    /**
     * Get all of the submissions for the assignment.
     */
    public function submissions(){
        return $this->hasManyThrough( Submission::class,StudentAssignment::class,);
    }
 

    

    public function start_time_string(){
        
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->start_time)->format('d/m/Y, H:i');
    }

    public function created_at_string(){
        
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->created_at)->format('d/m/Y, H:i');
    }

    public function updated_at_string(){
        
        return $this->updated_at ? Carbon::createFromFormat('Y-m-d H:i:s',$this->updated_at)->format('d/m/Y, H:i') : null;
    }

    public function start_time_carbon(){
        
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->start_time);
    }

    public function end_time_string(){
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->end_time)->format('d/m/Y, H:i');
    }
    public function end_time_carbon(){
        
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->end_time);
    }

    public function isOpen(){
        return $this->start_time_carbon()->lt(now()) && $this->end_time_carbon()->gt(now());
    }
}

