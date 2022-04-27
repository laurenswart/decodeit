<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;

class Teacher extends User
{
    use HasFactory, Billable;

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

    public function currentSubscription(){
        $subscription = Subscription::all()
            ->filter(function($item) {
                if (Carbon::now()->between($item->created_at, $item->ends_at)) {
                  return $item;
                }
              })
              ->where('user_id', $this->id)
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
            && $this->created_at->diffInDays(Carbon::now()) <= 3;
    }

    public function currentSubscriptionPlan(){
        $user = User::find($this->id);
        $plans = Plan::all();
        
        foreach($plans as $plan){
            if( $this->subscribed($plan->title)){
                return $plan;
            }
        }
        
        if($this->isOnFreeTrial()){
            return Plan::firstWhere('title', 'free');
        }
        return null;
    }
}
