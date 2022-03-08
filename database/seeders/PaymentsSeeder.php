<?php

namespace Database\Seeders;

use App\Models\Payments;
use App\Models\Subscriptions;
use App\Models\Teacher;
use Faker\Provider\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
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
        Payments::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //get teachers
        $teachers = Teacher::get();
        //free trial id
        $freeTrialRef = 1;
        $payments = [];
        //paymentsDurations
        $paymentsDurations = [1=>'monthly_price', 6=>'semiyearly_price', 12=>'yearly_price'];
        foreach($teachers as $teacher){
            //free trial
            $payments[] = [
                'teacher_ref'=> $teacher['user_id'],
                'subscription_ref'=> $freeTrialRef,
                'amount'=>0,
                'start_date'=>$teacher['created_at']->subDays(5),
                'expires'=>$teacher['created_at']->subDays(2),
                'created'=>now(),
            ];
            //paying subscription
            if($teacher['email']=='bsull@gmail.com'){
                //custom payment for bob sull
                $subscriptionRef = 5;
            } else {
                $subscriptionRef = rand(2,4);
            }
            $subscriptionInfo = Subscriptions::find($subscriptionRef);
            $paymentDurationId = array_rand($paymentsDurations);
            $payments[] = [
                'teacher_ref'=> $teacher['user_id'],
                'subscription_ref'=> $subscriptionRef,
                'amount'=>$subscriptionInfo[$paymentsDurations[$paymentDurationId]],
                'start_date'=>$teacher['created_at']->subDays(1),
                'expires'=>$teacher['created_at']->addMonths($paymentDurationId)->subDays(1),
                'created'=>now(),
            ];
        }

        //insert into table
        DB::table('payments')->insert($payments);
    }
}
