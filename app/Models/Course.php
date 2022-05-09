<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
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

    protected function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id' );
    }

    protected function chapters(){
        return $this->hasMany(Chapter::class, 'course_id', 'id' )->orderBy('order_id');
    }
    protected function skills(){
        return $this->hasMany(Skill::class, 'course_id', 'id' );
    }

    protected function messages(){
        return $this->hasMany(Message::class,  'course_id', 'id' );
    }

    protected function assignments(){
        return $this->hasMany(Assignment::class, 'course_id' , 'id');
    }

    public function students(){
        return $this->belongsToMany(Student::class, 'enrolments','course_id', 'student_id','id','id')->withPivot('id');
    }

    public function enrolmentForAuth(){
        $enrolment = Enrolment::all()
            ->where('student_id', Auth::id())
            ->where('course_id', $this->id)
            ->first();
        return $enrolment;
    }



    public function enrolmentIdForAuth(){
        return $this->enrolmentForAuth()->id;
    }

    public function enrolmentForStudent($id){
        $enrolment = Enrolment::all()
            ->where('student_id', $id)
            ->where('course_id', $this->id)
            ->first();
        return $enrolment;
    }

    public function enrolmentIdForStudent($id){
        return $this->enrolmentForStudent($id)->id;
    }

    public function hasNewMessages(){
        //todo
        return false;
        //return count($this->messages->where('created_at', '>=', Auth::user()->lastConnected())) > 0 ;
    }

    public function hasNewSubmissions(){
        //todo
        return false;
    }
    
}
