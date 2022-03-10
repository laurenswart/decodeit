<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends User
{
    use HasFactory;

    public function students(){
        return $this->belongsToMany(Student::class, 'teacher_student', 'teacher_ref', 'student_ref', 'user_id', 'user_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'teacher_ref', 'user_id' );
    }
    
    /**
     * The courses create by this teacher
     */
    public function courses(){
        return $this->hasMany(Course::class, 'teacher_ref', 'user_id' );
    }

    public function currentSubscription(){
        $payment =  Payment::where([
            ['teacher_ref', '=', $this->user_id],
            ['start_date', '<=', now()],
            ['expires', '>=', now()],
        ])->first();
            //var_dump(empty($payment) ? 'empty' : $payment->subscription_ref );
        return empty($payment) ? null : Subscription::find($payment->subscription_ref);
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleRef(1);
    }
}
