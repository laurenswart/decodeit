<?php

namespace App\Http\Middleware;

use App\Models\Teacher;
use Closure;
use Illuminate\Http\Request;

class EnsureActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $teacher = Teacher::find($request->user()->id);
        if ( $teacher->currentSubscription() === null && !$teacher->isOnFreeTrial()) {
            return redirect(route('teacher_account'))->with('flash_modal', 'You do not have an active subscription. Please choose one of our subscription plans, or renew your previous subscription.');
        }

        return $next($request);
    }
}
