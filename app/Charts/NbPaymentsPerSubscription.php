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
        return Chartisan::build();
           
    }
}