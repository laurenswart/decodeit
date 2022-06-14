<?php

namespace App\Mail;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Subscription;

class PaymentSucceeded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    public $user;
    public $payment;
    public $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Payment $payment, Subscription $subscription)
    {
        $this->user = $user;
        $this->payment = $payment;
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('information@decodeit.com', 'DecodeIt')
            ->view('emails.paymentSucceeded');
    }
}
