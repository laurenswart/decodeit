<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $table = 'skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description'
    ];

    public $timestamps = false;

    /**
     * The course associated to this enrolment
     */
    protected function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
