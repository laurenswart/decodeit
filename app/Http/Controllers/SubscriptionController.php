<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\StripeClient;

class SubscriptionController extends Controller
{
    
    public function createCheckoutSession(Request $request){
        if(empty( $request->post('price_id'))){
            return abort(403);
        } else if (!empty(Teacher::find(Auth::id())->currentSubscription())){
            //user already has a subscription
            return abort(403);
        }

        $stripeUser = Teacher::find(Auth::id())->createOrGetStripeCustomer();
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost:8000/teacher/account',
            'cancel_url' => 'http://localhost:8000/teacher/subscriptions/payment_failed',
            'line_items' => [
              [
                'price' => $request->post('price_id'),
                'quantity' => 1,
                
              ],
            ],
            'customer' => $stripeUser,
            'mode' => 'subscription',
          ]);
        
        return redirect( $session->url );

    }

    public function teacherFail(){
        return view('teacher.subscriptions.payment_failed');
    }

}
