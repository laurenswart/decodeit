<?php

namespace App\Jobs\StripeWebhooks;

use App\Mail\PaymentSucceeded;
use App\Models\Payment;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
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
        // Get info from stripe
        $charge = $this->webhookCall->payload['data']['object'];
        $priceDue = $charge['amount_due'];
        $pricePaid = $charge['amount_paid'];
        $invoiceId = $charge['id'];
        $country = $charge['account_country'];
        $reason = $charge['billing_reason'];
        $created = $charge['created'];
        $currency = $charge['currency'];
        $status = $charge['status'];
        $subscriptionId = $charge['subscription'];
       
        //get relevant subscription in our db
        $userId = User::where('stripe_id', $charge['customer'])->first()->id;
       
        //save to DB
        $payment = Payment::create([
            'teacher_id' => $userId,
            'amount_due' => $priceDue,
            'amount_paid' => $pricePaid,
            'stripe_invoice_id' => $invoiceId,
            'country' => $country,
            'reason' => $reason,
            'created_at' => Carbon::createFromTimestamp($created),
            'currency' => $currency,
            'status' => $status,
            'subscription_stripe_id' => $subscriptionId,
        ]);

        //send email
        $user = User::find($userId);
        Mail::to($user->email)
            ->send(new PaymentSucceeded($user, $payment, Teacher::find($userId)->currentSubscription()));
    }
}
