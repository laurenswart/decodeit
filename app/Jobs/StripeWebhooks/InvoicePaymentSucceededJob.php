<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\Payment;
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
        //save in payments table that an invoice was succesfully paid
        $charge = $this->webhookCall->payload['data']['object'];
       
        
        $userId = User::where('stripe_id', $charge['customer'])->first()->id;
        $priceDue = $charge['amount_due'];
        $pricePaid = $charge['amount_paid'];
        $invoiceId = $charge['id'];
        $country = $charge['account_country'];
        $reason = $charge['billing_reason'];
        $created = $charge['created'];
        $currency = $charge['currency'];
        $status = $charge['status'];
        $subscriptionId = $charge['subscription'];

        //save to DB
        Payment::create([
            'teacher_ref' => $userId,
            'amount_due' => $priceDue,
            'amount_paid' => $pricePaid,
            'stripe_invoice_id' => $invoiceId,
            'country' => $country,
            'reason' => $reason,
            'created_at' => Carbon::createFromTimestamp($created),
            'currency' => $currency,
            'status' => $status,
            'subscription_ref' => $subscriptionId,
        ]);
    }
}
