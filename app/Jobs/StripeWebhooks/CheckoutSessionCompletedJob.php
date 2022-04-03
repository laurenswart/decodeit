<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Spatie\WebhookClient\Models\WebhookCall;
use Stripe\StripeClient;

class CheckoutSessionCompletedJob implements ShouldQueue
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
        file_put_contents(__DIR__.'/test.php', 'In function');
        // Payment is successful and the subscription is created.
        // You should provision the subscription and save the customer ID to your database.
        $charge = $this->webhookCall->payload['data']['object'];
        $customer_stripe_id = $charge['customer'];

        //$user = Auth::user();
        $user = User::where('stripe_id', $charge['customer'])->first();
        $test = $charge['items']['data'];
        $price_ref = $charge['items']['data'][0]['price']->id;
        file_put_contents(__DIR__.'/test.php', 'Found user'.$user, FILE_APPEND);
        file_put_contents(__DIR__.'/test.php', 'Found price'.$price_ref, FILE_APPEND);
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $stripe->subscriptions->create([
            'customer' =>  $customer_stripe_id,
            'items' => [
              ['price' => $price_ref],
            ],
          ]);
    }
}
