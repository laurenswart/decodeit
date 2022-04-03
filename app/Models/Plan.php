<?php

namespace App\Models;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\SubscriptionItem as CashierSubscriptionItem;


class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    protected $primaryKey = 'plan_id';

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
        'monthly_link',
        'semiyearler_link',
        'yearly_link',
        'is_custom',
        'is_active',
        'created_at'
    ];

    /*
    protected function payments(){
        return $this->hasMany(Payment::class, 'subscription_id', 'subscription_ref');
    }

    public function nbUsers(){
        return Payment::all()
        ->where('subscription_ref', '=', $this->subscription_id)
        ->filter(function($item) {
            if (Carbon::now()->between($item->start_date, $item->expires)) {
              return $item;
            }
          })
        ->count();
    }

    public function nbRelatedPayments(){
        return Payment::all()
        ->where('subscription_ref', '=', $this->subscription_id)
        ->count();
    }
    */
}