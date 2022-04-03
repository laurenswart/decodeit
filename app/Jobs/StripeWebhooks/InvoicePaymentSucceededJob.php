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

class InvoicePaymentSucceededJob implements ShouldQueue
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
        
        $price = $charge['lines']['data'][0]['plan']['id'];
        $payment_intent = $charge['payment_intent'];
        $user = User::where('stripe_id', $charge['customer'])->first();
        /*
        Subscription::create([
            'customer' =>  $customer_stripe_id,
            'items' => [
              ['price' => $price],
            ],
          ]);*/
        $user->newSubscription(
            'default', $price 
        )->create();
    }
}
