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
        return $this->belongsToMany(Student::class, 'teacher_student', 'teacher_id', 'student_id', 'id', 'id');
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'teacher_id', 'id' );
    }
    
    /**
     * The courses create by this teacher
     */
    public function courses(){
        return $this->hasMany(Course::class, 'teacher_id', 'id' );
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
            ->whereRoleId(1);
    }

    public function isOnFreeTrial(){
        return $this->currentSubscription() == null 
            && Auth::user()->created_at->diffInDays(Carbon::now()) <= 3;
    }

}
