<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\StripeClient;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function createCheckoutSession(Request $request){
        if(empty( $request->post('price_id'))){
            //todo
            return;
        }
        $stripeUser = Auth::user()->createOrGetStripeCustomer();
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost:8000/teacher/account',
            'cancel_url' => 'http://localhost:8000/teacher/subscriptions/fail',
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

    public function teacherSuccess(Request $request){
        var_dump('payment succeeded');

    }

    public function teacherFail(){
        var_dump('payment failed');
    }

}
