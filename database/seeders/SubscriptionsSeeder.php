<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Carbon\Carbon;
use Database\Factories\SubscriptionFactory;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the table first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Subscription::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //create subscriptions
        $subscriptions = [
            [
                'title'=>'free',
                'description'=>'Free 3 day trial. Available upon registration, only once.',
                'nb_courses'=>1,
                'nb_submissions'=>1,
                'max_upload_size'=>10,
                'nb_chapters'=>1,
                'nb_students'=>1,
                'nb_assignments'=>1,
                'monthly_price'=>0,
                'semiyearly_price'=>0,
                'yearly_price'=>0,
                'is_custom'=>true,
                'is_active'=>true,
            ],
            [
                'title'=>'starter',
                'description'=>'',
                'nb_courses'=>3,
                'nb_submissions'=>2,
                'max_upload_size'=>10,
                'nb_chapters'=>10,
                'nb_students'=>25,
                'nb_assignments'=>30,
                'monthly_price'=>19.99,
                'semiyearly_price'=>104.99,
                'yearly_price'=>199.99,
                'is_custom'=>false,
                'is_active'=>true,
            ],
            [
                'title'=>'standard',
                'description'=>'',
                'nb_courses'=>5,
                'nb_submissions'=>3,
                'max_upload_size'=>20,
                'nb_chapters'=>15,
                'nb_students'=>50,
                'nb_assignments'=>60,
                'monthly_price'=>29.99,
                'semiyearly_price'=>157.99,
                'yearly_price'=>299.99,
                'is_custom'=>false,
                'is_active'=>true,
            ],
            [
                'title'=>'advanced',
                'description'=>'',
                'nb_courses'=>10,
                'nb_submissions'=>5,
                'max_upload_size'=>50,
                'nb_chapters'=>20,
                'nb_students'=>100,
                'nb_assignments'=>150,
                'monthly_price'=>49.99,
                'semiyearly_price'=>263.99,
                'yearly_price'=>499.99,
                'is_custom'=>false,
                'is_active'=>true,
            ],
            [
                'title'=>'Bob Sull',
                'description'=>'Custom Subscription for Bob Sull',
                'nb_courses'=>5,
                'nb_submissions'=>3,
                'max_upload_size'=>50,
                'nb_chapters'=>20,
                'nb_students'=>10,
                'nb_assignments'=>150,
                'monthly_price'=>9.99,
                'semiyearly_price'=>52.99,
                'yearly_price'=>99.99,
                'is_custom'=>true,
                'is_active'=>true,
            ],
        ];

        foreach( $subscriptions as &$subscription ){
            $subscription['created_at']  = Carbon::today()
                        ->subMonths(5)
                        ->subDays(rand(1,28))
                        ->subHours(rand(0,23))
                        ->subMinutes(rand(0,59))
                        ->subSeconds(rand(0,59));
        }

        DB::table('subscriptions')->insert($subscriptions);
    }
}
