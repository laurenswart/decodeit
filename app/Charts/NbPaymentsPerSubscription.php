<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Payment;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NbPaymentsPerSubscription extends BaseChart
{
    public ?string $routeName = 'nbPaymentsPerSubscription';
    public ?array $middlewares = ['adminauth'];

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        //payments
        $payments = DB::table('subscriptions')
            ->select('subscription_ref', 'amount', DB::raw('count(*) as counts'))
            ->leftJoin('payments', 'payments.subscription_ref', '=', 'subscriptions.subscription_id')
            ->where('amount', '!=', '0')
            ->groupBy(['subscription_ref', 'amount'])
            ->orderBy('subscription_ref')
            ->orderBy('amount')
            ->get();

        //retrieve and format subscription prices
        $subscriptions = DB::table('subscriptions')
            ->select('subscription_id', 'title', 'monthly_price', 'semiyearly_price', 'yearly_price')
            ->where('title', '!=', 'free')
            ->orderBy('subscription_id')
            ->get();
        foreach ($subscriptions as $subscription) {
            $subscriptionPrices[$subscription->subscription_id]['monthly'] = $subscription->monthly_price;
            $subscriptionPrices[$subscription->subscription_id]['semiyearly'] = $subscription->semiyearly_price;
            $subscriptionPrices[$subscription->subscription_id]['yearly'] = $subscription->yearly_price;
            $data['monthly'][$subscription->subscription_id] = 0;
            $data['semiyearly'][$subscription->subscription_id] = 0;
            $data['yearly'][$subscription->subscription_id] = 0;
            $labels[] = $subscription->title;
        }

        //prepare data for chart
        foreach ($payments as $payment) {
            $duration = array_search($payment->amount, $subscriptionPrices[$payment->subscription_ref]);
            $data[$duration][$payment->subscription_ref] = $payment->counts;
        }

        return Chartisan::build()
            ->labels($labels)
            ->dataset('Monthly', array_values($data['monthly']))
            ->dataset('Semiyearly', array_values($data['semiyearly']))
            ->dataset('Yearly', array_values($data['yearly']));
    }
}