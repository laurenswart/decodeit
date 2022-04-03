<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Subscription as CashierSubscription;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'payment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_ref',
        'plan_ref',
        'stripe_id',
        'subtotal',
        'tax',
        'total',
    ];

    public $timestamps = true;

    /**
     * The users that made the payment
     */
    public function teacher()
    {
      return $this->belongsTo(Teacher::class, 'teacher_ref', 'user_id');
    }

    
    /**
     * The users that made the payment
     */
    /*
    public function subscription()
    {
      return $this->belongsTo(Subscription::class, 'subscription_ref', 'subscription_id');
    }*/
}
