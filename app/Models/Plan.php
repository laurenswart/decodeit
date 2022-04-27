<?php

namespace App\Models;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem as CashierSubscriptionItem;


class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'nb_courses',
        'nb_submissions',
        'max_upload_size',
        'nb_chapters',
        'nb_students',
        'nb_assignments',
        'monthly_price',
        'semiyearler_price',
        'yearly_price',
        'monthly_stripe_id',
        'semiyearly_stripe_id',
        'yearly_stripe_id',
        'is_custom',
        'is_active',
        'created_at'
    ];

    
    protected function subscriptions(){
        return $this->hasMany( Subscription::class, 'title', 'name');
    }

    public function nbUsers(){
        return Subscription::all()
        ->where('name', '=', $this->title)
        ->filter(function($item) {
            if (Carbon::now()->between($item->created_at, $item->ends_at)) {
              return $item;
            }
          })
        ->count();
    }

}
