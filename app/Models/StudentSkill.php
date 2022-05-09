<?php

namespace App\Models;

use App\Http\Traits\HasCompositePrimaryKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StudentSkill extends Model
{
    use HasFactory, HasCompositePrimaryKeyTrait;

    protected $table = 'student_skills';
    protected $primaryKey = ['enrolment_id', 'skill_id'];
    public $incrementing = false;

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
