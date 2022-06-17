<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentNote extends Model
{
    use HasFactory;

    protected $table = 'assignment_notes';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assignment_id',
        'message',
        'created_at',
        'deleted_at'
    ];

    public $timestamps = true;


    /**
     * The assignment this note belongs to
     */
    protected function assignment(){
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }

}
