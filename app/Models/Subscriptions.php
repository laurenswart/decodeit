<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $primaryKey = 'subscription_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'nb_courses',
        'nb_submissions',
        'max_upload_size',
        'nb_chapters',
        'nb_students',
        'nb_assignments',
        'monthly_price',
        'semiyearler_price',
        'yearly_price',
        'is_custom',
        'is_active',
        'created_at'
    ];
}
