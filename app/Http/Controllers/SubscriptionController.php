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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherCreate(Request $request)
    {
        if(empty($request->post('plan_id')) || empty($request->post('duration'))){
            return view('teacher.subscription.index');
        }
        $plan_id = $request->post('plan_id');
        $duration = $request->post('duration');

        $plan = Plan::find($plan_id);

        if(empty($plan)){
            return view('teacher.subscription.index');
        }

        return view('teacher.subscription.create', [
            'plan'=>$plan,
            'duration'=>$duration,
            'price_token'=>$duration.'_price',
            'price_key'=>'price_1KkBOHIwM966ChVuaWm2SvSL'//todo make dynamic : this is monthly price starter
        ]);
    }


    public function createCheckoutSession(Request $request){
        if(empty( $request->post('price_id'))){
            //todo
            return;
        }
        $stripeUser = Auth::user()->createOrGetStripeCustomer();
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost:8000/teacher/subscriptions/success',
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
        //var_dump($session->url);

    }

    public function teacherSuccess(Request $request){
        var_dump('payment succeeded');

    }

    public function teacherFail(){
        var_dump('payment failed');
    }

}
