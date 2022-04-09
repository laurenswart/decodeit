<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(Student::class, 'enrolments','course_id', 'student_id','id','id');
    }

    public function enrolmentForAuth(){
        $enrolment = Enrolment::all()
            ->where('student_id', Auth::id())
            ->where('course_id', $this->id)
            ->first();
        return $enrolment->id;
    }
    
}
