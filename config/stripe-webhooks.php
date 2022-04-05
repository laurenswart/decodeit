<?php

use App\Jobs\StripeWebhooks\ChargeSucceededJob;
use App\Jobs\StripeWebhooks\CustomerSubscriptionCreatedJob;
use App\Jobs\StripeWebhooks\CustomerSubscriptionDeleted;
use App\Jobs\StripeWebhooks\CustomerSubscriptionDeletedJob;
use App\Jobs\StripeWebhooks\CustomerSubscriptionUpdatedJob;
use App\Jobs\StripeWebhooks\InvoicePaymentSucceededJob;
use App\Jobs\StripeWebhooks\PaymentMethodAttached;
use App\Jobs\StripeWebhooks\PaymentMethodAttachedJob;

return [
    /*
     * Stripe will sign each webhook using a secret. You can find the used secret at the
     * webhook configuration settings: https://dashboard.stripe.com/account/webhooks.
     */
    'signing_secret' => env('STRIPE_WEBHOOK_SECRET'),

    /*
     * You can define the job that should be run when a certain webhook hits your application
     * here. The key is the name of the Stripe event type with the `.` replaced by a `_`.
     *
     * You can find a list of Stripe webhook types here:
     * https://stripe.com/docs/api#event_types.
     */
    'jobs' => [
        //'charge_succeeded' => ChargeSucceededJob::class,
        'invoice_payment_succeeded' => InvoicePaymentSucceededJob::class,
        //'payment_method_attached' => PaymentMethodAttachedJob::class,
        'customer_subscription_created' => CustomerSubscriptionCreatedJob::class,
        'customer_subscription_updated' => CustomerSubscriptionUpdatedJob::class,
        'customer_subscription_deleted' => CustomerSubscriptionDeletedJob::class,
        // 'source_chargeable' => \App\Jobs\StripeWebhooks\HandleChargeableSource::class,
        // 'charge_failed' => \App\Jobs\StripeWebhooks\HandleFailedCharge::class,
    ],

    /*
     * The classname of the model to be used. The class should equal or extend
     * Spatie\WebhookClient\Models\WebhookCall.
     */
    'model' => \Spatie\WebhookClient\Models\WebhookCall::class,

    /**
     * This class determines if the webhook call should be stored and processed.
     */
    'profile' => \Spatie\StripeWebhooks\StripeWebhookProfile::class,

    /*
     * When disabled, the package will not verify if the signature is valid.
     * This can be handy in local environments.
     */
    'verify_signature' => env('STRIPE_SIGNATURE_VERIFY', true),
];
