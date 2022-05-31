<?php

namespace Database\Seeders;

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
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
        Plan::truncate();
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
                'monthly_stripe_id'=>'',
                'semiyearly_stripe_id'=>'',
                'yearly_stripe_id'=>'',
                'is_custom'=>true,
                'is_active'=>true,
            ],
            [
                'title'=>'starter',
                'description'=>'Suitable for a small class, with minimal assignments.',
                'nb_courses'=>3,
                'nb_submissions'=>2,
                'max_upload_size'=>10,
                'nb_chapters'=>10,
                'nb_students'=>25,
                'nb_assignments'=>30,
                'monthly_price'=>4.99,
                'semiyearly_price'=>27.99,
                'yearly_price'=>55.99,
                'monthly_stripe_id'=>'price_1L5PFcIwM966ChVuRMM41wHd',
                'semiyearly_stripe_id'=>'price_1L5PG1IwM966ChVuAJDaKhVM',
                'yearly_stripe_id'=>'price_1L5PFcIwM966ChVulCBjnMqR',
                'is_custom'=>false,
                'is_active'=>true,
            ],
            [
                'title'=>'standard',
                'description'=>'If your aim is to provide short courses for varying groups of students, this package is likely sufficient.',
                'nb_courses'=>5,
                'nb_submissions'=>3,
                'max_upload_size'=>20,
                'nb_chapters'=>15,
                'nb_students'=>50,
                'nb_assignments'=>60,
                'monthly_price'=>29.99,
                'semiyearly_price'=>157.99,
                'yearly_price'=>299.99,
                'monthly_stripe_id'=>'price_1L5PHNIwM966ChVuNVu7opzl',
                'semiyearly_stripe_id'=>'price_1L5PHNIwM966ChVuziqtuBoq',
                'yearly_stripe_id'=>'price_1L5PHNIwM966ChVu80ta79Rw',
                'is_custom'=>false,
                'is_active'=>true,
            ],
            [
                'title'=>'advanced',
                'description'=>'Provide multiple courses to different groups of students with plenty of flexibility.',
                'nb_courses'=>10,
                'nb_submissions'=>5,
                'max_upload_size'=>50,
                'nb_chapters'=>20,
                'nb_students'=>100,
                'nb_assignments'=>150,
                'monthly_price'=>49.99,
                'semiyearly_price'=>263.99,
                'yearly_price'=>499.99,
                'monthly_stripe_id'=>'price_1L5PIbIwM966ChVujfzvrv6s',
                'semiyearly_stripe_id'=>'price_1L5PIbIwM966ChVuG3dWxl76',
                'yearly_stripe_id'=>'price_1L5PIbIwM966ChVub2nfzcPA',
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
                'monthly_stripe_id'=>'price_1KkEkqIwM966ChVudSUO5gej',
                'semiyearly_stripe_id'=>'price_1KkEkqIwM966ChVuKGMl9MzP',
                'yearly_stripe_id'=>'price_1KkEkqIwM966ChVu1PnZU88c',
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

        DB::table('plans')->insert($subscriptions);
    }
}
