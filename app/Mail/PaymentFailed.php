<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PaymentFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    public $user;
    public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Payment $payment)
    {
        $this->user = $user;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('information@decodeit.com', 'DecodeIt')
            ->view('emails.paymentFailed');
    }
}
