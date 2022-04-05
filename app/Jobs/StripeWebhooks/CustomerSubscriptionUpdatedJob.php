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

class  CustomerSubscriptionUpdatedJob implements ShouldQueue
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

        //get relevant subscription in our db
        $subscription = Subscription::
            where('stripe_id', $charge['id'] );

        if(!$subscription){
            //return relevant error code
            return;
        }
        
        //if user decided to cancel subscription, mark it as canceled
        //they will still have access to the application until end_at
        $status = $charge['status'];
        if($charge["cancel_at_period_end"]){
            $status = 'canceled';
        }

        //update our database
        $subscription->update([
            'stripe_status' => $status,
            'ends_at'=> Carbon::createFromTimestamp($charge['current_period_end']),
            'updated_at' => Carbon::now()
        ]);
    }
}
