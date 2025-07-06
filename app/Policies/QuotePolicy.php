<?php

// app/Policies/QuotePolicy.php
namespace App\Policies;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Quote $quote)
    {
        return $user->hasRole('admin') || 
               ($user->hasRole('seller') && $quote->product->user_id === $user->id) || 
               ($user->hasRole('buyer') && $quote->buyer_id === $user->id);
    }

    public function respond(User $user, Quote $quote)
    {
        return $user->hasRole('seller') && $quote->product->user_id === $user->id;
    }

    public function delete(User $user, Quote $quote)
    {
        return $user->hasRole('admin') || ($user->hasRole('buyer') && $quote->buyer_id === $user->id);
    }
}