<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\Payment;
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

class PaymentMethodAttachedJob implements ShouldQueue
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
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $customer_stripe_id = $charge['customer'];
        
        $paymentId = $charge['id'];
        $user = User::where('stripe_id', $charge['customer'])->first();
        
        $stripe->paymentMethods->attach(
            $paymentId,
            ['customer' => $customer_stripe_id]
          );
    }
}
