<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Teacher;
use Carbon\Carbon;
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
        Payment::truncate();
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
            $freeTrialDays = rand(0,3);
            $payments[] = [
                'teacher_ref'=> $teacher['user_id'],
                'subscription_ref'=> $freeTrialRef,
                'amount'=>0,
                'start_date'=>$teacher['created_at'],
                'expires'=>$teacher['created_at']->addDays($freeTrialDays),
                'created_at'=> $teacher['created_at'],
            ];
            //paying subscription
            if($teacher['email']=='bsull@gmail.com'){
                //custom payment for bob sull
                $subscriptionRef = 5;
            } else {
                $subscriptionRef = rand(2,4);
            }
            $subscriptionInfo = Subscription::find($subscriptionRef);
            $paymentDurationId = array_rand($paymentsDurations);
            $payments[] = [
                'teacher_ref'=> $teacher['user_id'],
                'subscription_ref'=> $subscriptionRef,
                'amount'=>$subscriptionInfo[$paymentsDurations[$paymentDurationId]],
                'start_date'=>$teacher['created_at']->addDays($freeTrialDays),
                'expires'=>$teacher['created_at']->addDays($freeTrialDays)->addMonths($paymentDurationId),
                'created_at'=>now(),
            ];
        }

        //insert into table
        DB::table('payments')->insert($payments);
    }
}
