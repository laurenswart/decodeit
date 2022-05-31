<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Subscription;

class StripeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Payment::truncate();
        DB::table('subscriptions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //get stripe customers
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $customers = $stripe->customers->all(['limit'=>100]);

        //dd($customers);
        $paymentsToCreate = [];
        $subscriptionsToCreate = [];
        foreach($customers as $customer){
            //create teacher
            $teacher = User::factory()->role('teacher')->create([
                'email'=> $customer->email, 
                'stripe_id' => $customer->id,
                'role_id'=>1
            ]);

            $subscriptions = $stripe->subscriptions->all(['customer' => $customer->id, 'limit'=>1]);
            if(empty($subscriptions->data)){
                continue;
            }
            
            $item = $subscriptions->data[0];
            //get relevant plan in our db
            $stripe_price_id = $item->items->data[0]->price->id;
            $plan = Plan::firstWhere(function($q) use ($stripe_price_id) {
                $q->where('monthly_stripe_id', $stripe_price_id)
                ->orWhere('semiyearly_stripe_id', $stripe_price_id)
                ->orWhere('yearly_stripe_id', $stripe_price_id);
            });
            $planName = $plan ? $plan->title : 'unknown';
            $planName = str_replace(' ', '_', strtolower($planName));

            //create payments
            $invoices = $stripe->invoices->all(['customer' => $customer->id]);
            foreach($invoices as $invoice){
                //var_dump('invoice ', Carbon::createFromTimestamp($invoice->created));
                $paymentsToCreate[] = [
                    'teacher_id' => $teacher->id,
                    'amount_due' => $invoice->amount_due,
                    'amount_paid' => $invoice->amount_paid,
                    'stripe_invoice_id' => $invoice->id,
                    'country' => $invoice->account_country,
                    'reason' => $invoice->billing_reason,
                    'created_at' => Carbon::createFromTimestamp($invoice->created),
                    'currency' => $invoice->currency,
                    'status' => $invoice->status,
                    'subscription_stripe_id' => $invoice->subscription,
                ];
            }

            //create subscription
            $subscriptionsToCreate[] = [
                'teacher_id' =>  $teacher->id,
                'name' => $planName,
                'stripe_id' => $item->items->data[0]->subscription,
                'stripe_status' => $item->status,
                'stripe_price' => $stripe_price_id,
                'quantity' => $item->quantity,
                'trial_ends_at' => NULL,
                'ends_at' =>Carbon::createFromTimestamp( $item->current_period_end),
                'created_at' => Carbon::createFromTimestamp($item->start_date),
                'updated_at' => Carbon::createFromTimestamp($item->start_date)
            ];

            
        }
        //return;
        DB::table('payments')->insert($paymentsToCreate);
        DB::table('subscriptions')->insert($subscriptionsToCreate);

        
       
    }
}
