<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Builder\Stub;

class Chapter extends Model
{
    use HasFactory;

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
        $enrolmentId = $this->course->enrolmentForAuth();
        $read = DB::table('chapters_read')
            ->where('enrolment_id', $enrolmentId)
            ->where('chapter_id', $this->id)
            ->count();
        ;
        return $read == 1;
    }

    public function nbAssignmentsDone(){
        $assignmentIds = $this->assignments->pluck('assignment_id');
        $enrolmentId = $this->course->enrolmentForAuth();

        $nbDone = DB::table('student_assignment')
            ->where('enrolment_id', $enrolmentId)
            ->whereIn('assignment_id', $assignmentIds)
            ->where('to_mark', true)->count();

        return $nbDone;
    }

    public function isRead($userId){
        $enrolmentId = Enrolment::where('student_id', $userId)
            ->where('course_id', $this->course_id)->first();
        if(empty($enrolmentId)) return false;
        
        $row = DB::table('chapters_read')
            ->where('enrolment_id', $enrolmentId)
            ->where('chapter_id', $this->id)
            ->all();
        
        return count($row)==1;
    }

    
}
