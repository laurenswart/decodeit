<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Builder\Stub;

class Chapter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chapters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'content',
        'is_active',
        'order_id'
    ];

    public $timestamps = true;

    protected function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    protected function assignments(){
        return $this->belongsToMany(Assignment::class, 'assignment_chapter', 'chapter_id', 'assignment_id', 'id', 'id');
    }

    public function read(){
        $enrolmentId = $this->course->enrolmentForAuth()->id;
        $read = DB::table('chapters_read')
            ->where('enrolment_id', $enrolmentId)
            ->where('chapter_id', $this->id)
            ->count();
        ;
        
        return $read == 1;
    }

    public function nbAssignmentsDone(){
        $assignmentIds = $this->assignments->pluck('id');
        $enrolment = Course::find($this->course_id)->enrolmentForAuth();

        $nbDone = DB::table('assignments')
           
            ->whereIn('assignments.id', $assignmentIds)
            ->leftJoin('student_assignment', 'assignments.id', 'student_assignment.assignment_id')
            
           
            ->where(function ($query) use ($enrolment){
                $query->where('enrolment_id', $enrolment->id)
                      ->orWhereNull('enrolment_id');
            })
             
            ->where(function ($query){
                $query->where('to_mark', 1)
                      ->orWhereNotNull('mark')
                      ->orWhere('end_time', '<=', now()->format('Y-m-d H:i:s'));
            })->count();
        return $nbDone;
    }

    public function isRead($userId){
        $enrolment = Enrolment::where('student_id', $userId)
            ->where('course_id', $this->course_id)->first();
        if(empty($enrolment)) return false;
        return  $enrolment->chaptersRead->contains($this);
    }

    
}
