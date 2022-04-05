<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
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

class  CustomerSubscriptionDeletedJob implements ShouldQueue
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
        //$stripe = new StripeClient(env('STRIPE_SECRET'));
        
        //$customer_stripe_id = $charge['customer'];
        //$payment_intent = $charge['payment_intent'];
        //$user = User::where('stripe_id', $customer_stripe_id)->first();
        /*
        $subscription = Subscription::
            where('created_at', Carbon::createFromTimestamp($charge['start_date']) )
            ->where('stripe_price', $charge['plan']['id'])
            ->where('user_id', $user->id);
        */
        $subscription = Subscription::
            where('stripe_id', $charge['id'] );

        $subscription->update([
            'stripe_status' => $charge['status']
        ]);
    }
}
