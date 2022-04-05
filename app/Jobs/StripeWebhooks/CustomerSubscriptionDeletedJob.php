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
        // Get info from stripe
        $charge = $this->webhookCall->payload['data']['object'];
        
        //get relevant subscription in our db
        $subscription = Subscription::
            where('stripe_id', $charge['id'] );

        //update our database
        $subscription->update([
            'stripe_status' => $charge['status']
        ]);
    }
}
