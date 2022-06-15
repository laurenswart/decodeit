<?php

namespace App\Jobs\StripeWebhooks;

use App\Mail\RegistrationConfirmed;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        // Get info from stripe
        $charge = $this->webhookCall->payload['data']['object'];
        $stripe_price = $charge['plan']['id'];

        //get relevant subscription in our db
        $plan = Plan::firstWhere(function($q) use ($stripe_price) {
            $q->where('monthly_stripe_id', $stripe_price)
            ->orWhere('semiyearly_stripe_id', $stripe_price)
            ->orWhere('yearly_stripe_id', $stripe_price);
        });
        $planName = $plan ? $plan->title : 'unknown';
        $planName = str_replace(' ', '_', strtolower($planName));
       
        //update our database
        $user = User::where('stripe_id', $charge['customer'])->first();
        Subscription::create([
            'teacher_id' =>  $user->id,
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

        //send email 
        Mail::to($user->email)->send(new RegistrationConfirmed($user));
    }
}
