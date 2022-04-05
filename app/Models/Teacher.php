<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Subscription;

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

    public function currentSubscriptionPlan(){
        $plans = Plan::all();
        foreach($plans as $plan){
            if(Auth::user()->subscribed($plan->title)){
                return $plan;
            }
        }
        return null;
    }

    public function currentSubscription(){
        $subscription = Subscription::all()
            ->filter(function($item) {
                if (Carbon::now()->between($item->created_at, $item->ends_at)) {
                  return $item;
                }
              })
              ->where('user_id', Auth::id())
              ->first();
        return $subscription;
    }

    

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleRef(1);
    }

}
