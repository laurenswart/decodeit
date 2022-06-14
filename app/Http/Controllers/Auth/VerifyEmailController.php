<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationConfirmed;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect( Auth::user()->role->name == 'teacher' ? route('teacherDashboard') : route('studentDashboard'));
        }

        if ($request->user()->markEmailAsVerified()) {
           
            event(new Verified($request->user()));
        }
        //send confirmation email
        $user = $request->user();
        Mail::to($user->email)
            ->send(new RegistrationConfirmed($user));

        return redirect( $user->role->name == 'teacher' ? route('teacherDashboard') : route('studentDashboard'));
    }
}
