<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function adminIndex(){
        $subscriptions = Subscription::all();

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

    public function adminShow(int $id){
        $subscription = Subscription::find($id);

        return view('admin.subscription.show', [
            'subscription' => $subscription
        ]);
    }
}
