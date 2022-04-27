<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Show subscriptions for the authenticated admin
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(){

        $plans = Plan::all();

        /*
         SELECT NAME, created_at, ends_at,
        TIMESTAMPDIFF(MONTH, created_at, ends_at)
        from subscriptions
         */
        $activeSubscriptions = DB::table('subscriptions')
            ->select(DB::raw(', name, TIMESTAMPDIFF(MONTH, created_at, ends_at)'))
            ->where('created_at', '<=', now())
            ->where('ends_at', '>=', now())->count();

        $nbMonthly = DB::table('subscriptions')
            ->where('created_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->whereRaw('TIMESTAMPDIFF(MONTH, created_at, ends_at)>=12')->count();

        $nbSemiyearly = DB::table('subscriptions')
            ->where('created_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->whereRaw('TIMESTAMPDIFF(MONTH, created_at, ends_at)>=6 && TIMESTAMPDIFF(MONTH, created_at, ends_at)<12')->count();

        $nbYearly = DB::table('subscriptions')
            ->where('created_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->whereRaw('TIMESTAMPDIFF(MONTH, created_at, ends_at)>=1 && TIMESTAMPDIFF(MONTH, created_at, ends_at)<6')->count();

        return view('admin.plan.index', [
            'plans' => $plans,
            'nbMonthly' => $nbMonthly,
            'nbSemiyearly' => $nbSemiyearly,
            'nbYearly' => $nbYearly,
            'activeSubscriptions' => $activeSubscriptions,
        ]);
        
    }

    /**
     * Show subscription for the authenticated admin
     *
     * @param int $id Id of the subscription
     * @return \Illuminate\Http\Response
     */
    public function adminShow(int $id){
        $plan = Plan::find($id);
        return view('admin.plan.show', [
            'plan' => $plan
        ]);
    }

    public function teacherIndex(){

       
       
        //todo redirect if user already has a valid running subscription
        $hasSubscription = Teacher::find(Auth::id())->currentSubscription() ? true : false;

        $plans = Plan::all()->where('is_active', true)->where('is_custom', false);
        return view('teacher.plan.index', [
            'plans'=>$plans,
            'hasSubscription'=>$hasSubscription 
        ]);
    }
}
