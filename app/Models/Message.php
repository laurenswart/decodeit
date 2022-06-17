<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'forum_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'user_id',
        'content',
    ];

    public $timestamps = true;

    /**
     * The course this message belongs to
     */
    protected function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id' );
    }

    /**
     * The user who wrote this message
     */
    protected function user(){
        return $this->belongsTo(User::class, 'user_id', 'id' );
    }
}
