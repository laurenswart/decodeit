<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;
use Spatie\WebhookClient\Models\WebhookCall;
use Stripe\StripeClient;

class  CustomerSubscriptionCreatedJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        // Payment is successful and the subscription is created.
        // You should provision the subscription and save the customer ID to your database.
        $charge = $this->webhookCall->payload['data']['object'];
       
        
        $customer_stripe_id = $charge['customer'];
    
        $stripe_price = $charge['plan']['id'];
        $plan = Plan::firstWhere(function($q) use ($stripe_price) {
            $q->where('monthly_stripe_id', $stripe_price)
            ->orWhere('semiyearly_stripe_id', $stripe_price)
            ->orWhere('yearly_stripe_id', $stripe_price);
        });
        $planName = $plan ? $plan->title : 'unknown';
        $planName = str_replace(' ', '_', strtolower($planName));
      
        //$payment_intent = $charge['payment_intent'];
        //$user = User::where('stripe_id', $charge['customer'])->first();

        file_put_contents('test.php', $planName);
        
        Subscription::create([
            'user_id' =>  User::where('stripe_id', $charge['customer'])->first()->id,
            'name' => $planName,
            'stripe_id' => $charge['id'],
            'stripe_status' => $charge['status'],
            'stripe_price' => $stripe_price,
            'quantity' => 1,
            'trial_ends_at'=> null,
            'ends_at'=> $charge['current_period_end'],
            'created_at'=> $charge['start_date'],
            'updated_at' => null
        ]);
    }
}
