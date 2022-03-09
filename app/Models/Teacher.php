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
        return $this->hasMany(Payments::class, 'user_id', 'teacher_ref');
    }

    public function currentSubscription(){
        $payment =  Payments::where([
            ['teacher_ref', '=', $this->user_id],
            ['start_date', '<=', now()],
            ['expires', '>=', now()],
        ])->first();
            //var_dump(empty($payment) ? 'empty' : $payment->subscription_ref );
        return empty($payment) ? null : Subscriptions::find($payment->subscription_ref);
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleRef(1);
    }
}
