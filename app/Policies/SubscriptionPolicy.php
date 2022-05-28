<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

}
