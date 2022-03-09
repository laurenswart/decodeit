<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapters';

    protected $primaryKey = 'chapter_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_ref',
        'title',
        'content',
        'is_active',
        'order_id'
    ];

    public $timestamps = true;

    protected function course(){
        return $this->belongsTo(Course::class);
    }
}
