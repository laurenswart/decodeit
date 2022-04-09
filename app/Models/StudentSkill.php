<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSkill extends Model
{
    use HasFactory;

    protected $table = 'student_skills';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enrolment_id',
        'skill_id',
        'mark',
    ];

    public $timestamps = false;

    protected function skill(){
        return $this->belongsTo(Skill::class, 'skill_id', 'id');
    }
}
