<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'title',
        'is_active',
    ];

    public $timestamps = true;

    /**
     * The teacher this course belongs to
     */
    protected function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id' );
    }

    /**
     * The chapters related to this course
     */
    protected function chapters(){
        return $this->hasMany(Chapter::class, 'course_id', 'id' )->orderBy('order_id');
    }
    /**
     * The skills to acquire for this course
     */
    protected function skills(){
        return $this->hasMany(Skill::class, 'course_id', 'id' );
    }

    /**
     * The messages in the forum of this course
     */
    protected function messages(){
        return $this->hasMany(Message::class,  'course_id', 'id' );
    }

    /**
     * The assignments related to this course
     */
    protected function assignments(){
        return $this->hasMany(Assignment::class, 'course_id' , 'id');
    }

    /**
     * The enrolments to this course
     */
    protected function enrolments(){
        return $this->hasMany(Enrolment::class, 'course_id' , 'id');
    }

    /**
     * The students currently enrolled in this course
     */
    public function students(){
        return $this->belongsToMany(Student::class, 'enrolments','course_id', 'student_id','id','id')->withPivot('id')->whereNull('enrolments.deleted_at');
    }

    /**
     * The number of chapters read by a student in this course
     * 
     * @param Int $studentId Id of the student
     * @return Int The number of chapters in this course read by the student 
     */
    public function nbChaptersRead($studentId){
        $enrolment = $this->enrolmentForStudent($studentId);
        return DB::table('chapters_read')->whereIn('chapter_id', $this->chapters->pluck('id'))->where('enrolment_id', $enrolment->id)->count();
    }

    /**
     * The enrolment to this course for the currently authenticated student
     * 
     * @return Enrolment|null Enrolment model instance, null if the student is not currently enroled in this course
     */
    public function enrolmentForAuth(){
        $enrolment = Enrolment::all()
            ->where('student_id', Auth::id())
            ->where('course_id', $this->id)
            ->first();
        return $enrolment;
    }

    /**
     * The enrolment id to this course for the currently authenticated student
     * 
     * @return Int|null Enrolment id, null if the student is not currently enroled in this course
     */
    public function enrolmentIdForAuth(){
        $enrolment = $this->enrolmentForAuth();
        return $enrolment ? $enrolment->id : null;
    }

    /**
     * The enrolment to this course for a student
     * 
     * @param Int $id Id of the student
     * @return Enrolment|null Enrolment model instance, null if the student is not currently enroled in this course
     */
    public function enrolmentForStudent($id){
        $enrolment = Enrolment::all()
            ->where('student_id', $id)
            ->where('course_id', $this->id)
            ->first();
        return $enrolment;
    }

    /**
     * The enrolment id to this course for ta student
     * 
     * @param Int $id Id of the student
     * @return Int|null Enrolment id, null if the student is not currently enroled in this course
     */
    public function enrolmentIdForStudent($id){
        $enrolment = $this->enrolmentForStudent($id);
        return $enrolment ? $enrolment->id : null;
    }
    
}
