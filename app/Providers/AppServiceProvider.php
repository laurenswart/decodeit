<?php

namespace App\Providers;

use App\Charts\NbPaymentsPerSubscription;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\Teacher;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\InscriptionsPerMonth::class,
            \App\Charts\StudentsPerTeacher::class,
            \App\Charts\TeachersPerStudent::class   ,
            \App\Charts\NbPaymentsPerSubscription::class,
            \App\Charts\ProfitPerSubscription::class,
        ]);

       
        //Cashier::useSubscriptionModel(Payment::class);
        //Cashier::useSubscriptionItemModel(Subscription::class);
    }
}
