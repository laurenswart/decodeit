<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Subscription as CashierSubscription;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'teacher_ref',
      'amount_due',
      'amount_paid',
      'stripe_invoice_id',
      'country',
      'reason',
      'created_at',
      'currency',
      'status',
      'subscription_ref',
    ];

    public $timestamps = false;

    /**
     * The users that made the payment
     */
    public function teacher()
    {
      return $this->belongsTo(Teacher::class, 'teacher_ref', 'id');
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
