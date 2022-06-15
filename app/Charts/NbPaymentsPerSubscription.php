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
     * Creates a Chart representing the number of payments per subscription
     * 
     * @param Illuminate\Http\Request $request
     * @return Chartisan\PHP\Chartisan Chart
     */
    public function handler(Request $request): Chartisan
    {
        return Chartisan::build();
           
    }
}