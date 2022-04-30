<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $table = 'submissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_assignment_id',
        'content',
        'status',
        'feedback',
        'console',
        'created_at',
        'updated_at',
        'question'
    ];

    public $timestamps = true;

    public function studentAssignment(){
        return $this->belongsTo(StudentAssignment::class, 'student_assignment_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y H:i');
    }
}
