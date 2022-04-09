<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Plan;
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

        /*
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
                'teacher_id'=> $teacher['id'],
                'subscription_ref'=> $freeTrialRef,
                'amount'=>0,
                'start_date'=>$teacher['created_at'],
                'expires'=>$teacher['created_at']->addDays($freeTrialDays),
                'created_at'=> $teacher['created_at'],
            ];
            
            //paying subscription
            if($teacher['email']=='bsull@gmail.com'){
                //custom payment for bob sull
                $planRef = 5;
            } else {
                $planRef = rand(2,4);
            }
            $planInfo = Plan::find($planRef);
            
            //pay until subscription passes today
            $passedCurrentDate = false;
            $endPreviousExpires = $teacher['created_at']->addDays($freeTrialDays);
            while(!$passedCurrentDate){
                $paymentDurationId = array_rand($paymentsDurations);
                $payments[] = [
                    'teacher_id'=> $teacher['id'],
                    'subscription_ref'=> $planRef,
                    'amount'=>$planInfo[$paymentsDurations[$paymentDurationId]],
                    'start_date'=> clone $endPreviousExpires,
                    'expires'=> (clone $endPreviousExpires)->addMonths($paymentDurationId),
                    'created_at'=> clone $endPreviousExpires,
                ];
                $passedCurrentDate = $teacher['created_at']->addDays($freeTrialDays)->addMonths($paymentDurationId) > now();
                $endPreviousExpires = $endPreviousExpires->addMonths($paymentDurationId);
            }
        }

        //insert into table
        DB::table('payments')->insert($payments);
        */
    }
}
