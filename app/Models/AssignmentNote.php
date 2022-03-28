<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentNote extends Model
{
    use HasFactory;

    protected $table = 'assignment_notes';

    protected $primaryKey = 'note_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assignment_ref',
        'message',
        'created_at',
        'deleted_at'
    ];

    public $timestamps = true;

    protected function assignment(){
        return $this->belongsTo(Assignment::class, 'assignment_ref', 'assignment_id');
    }

}