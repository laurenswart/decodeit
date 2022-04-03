<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Show subscriptions for the authenticated admin
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(){
        $subscriptions = Plan::all();

        $nbSemiyearly = DB::table('payments')
            ->join('subscriptions', 'subscription_id', '=', 'subscription_ref')
            ->whereRaw('semiyearly_price = `amount`')
            ->where('start_date', '<=', now())
            ->where('expires', '>=', now())
            ->count();
        $nbMonthly = DB::table('payments')
            ->join('subscriptions', 'subscription_id', '=', 'subscription_ref')
            ->whereRaw('monthly_price = `amount`')
            ->where('start_date', '<=', now())
            ->where('expires', '>=', now())
            ->count();
        $nbYearly = DB::table('payments')
            ->join('subscriptions', 'subscription_id', '=', 'subscription_ref')
            ->whereRaw('yearly_price = `amount`')
            ->where('start_date', '<=', now())
            ->where('expires', '>=', now())
            ->count();
        
        return view('admin.subscription.index', [
            'subscriptions' => $subscriptions,
            'nbMonthly' => $nbMonthly,
            'nbSemiyearly' => $nbSemiyearly,
            'nbYearly' => $nbYearly
        ]);
        
    }

    /**
     * Show subscription for the authenticated admin
     *
     * @param int $id Id of the subscription
     * @return \Illuminate\Http\Response
     */
    public function adminShow(int $id){
        $subscription = Plan::find($id);
        return view('admin.subscription.show', [
            'subscription' => $subscription
        ]);
    }

    public function teacherIndex(){
        $plans = Plan::all()->where('is_active', true)->where('is_custom', false);
        return view('teacher.plan.index', [
            'plans'=>$plans
        ]);
    }
}
