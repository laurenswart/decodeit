<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfitPerSubscription extends BaseChart
{
    public ?string $routeName = 'profitPerSubscription';
    public ?array $middlewares = ['adminauth'];

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        //payments
        $datas = DB::table('plans')
            ->select('plans.title', DB::raw('sum(amount_paid) as total'))
            ->leftJoin('subscriptions', 'subscriptions.name', '=', 'plans.title')
            ->leftJoin('payments', 'subscriptions.stripe_id', '=', 'payments.subscription_stripe_id')
            ->where('title', '!=', 'free')
            ->groupBy(['title'])
            ->orderBy('plans.id')
            ->get();

        $keys = [];
        $values = [];

        foreach($datas as $data){
            $keys[] = $data->title;
            $values[] = $data->total/100;
        }


        return Chartisan::build()
            ->labels($keys)
            ->dataset('', $values);
    }
}