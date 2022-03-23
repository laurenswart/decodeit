<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function adminIndex(){
        $subscriptions = Subscription::all();

        return view('admin.subscription.index', [
            'subscriptions' => $subscriptions
        ]);
    }

    public function adminShow(int $id){
        $subscription = Subscription::find($id);

        return view('admin.subscription.show', [
            'subscription' => $subscription
        ]);
    }
}
