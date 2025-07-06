<?php

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuotePolicy
{
    /**
     * Determine whether the user can view any quotes.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Buyer', 'Seller', 'Admin']);
    }

    /**
     * Determine whether the user can view the quote.
     */
    public function view(User $user, Quote $quote): bool
    {
        return $user->hasRole('Admin') || 
               $user->id === $quote->buyer_id || 
               $user->id === $quote->seller_id;
    }

    /**
     * Determine whether the user can create quotes.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Buyer');
    }

    /**
     * Determine whether the user can update the quote.
     */
    public function update(User $user, Quote $quote): bool
    {
        // Only sellers can update quotes (respond to them)
        return $user->hasRole('Seller') && $user->id === $quote->seller_id;
    }

    /**
     * Determine whether the user can delete the quote.
     */
    public function delete(User $user, Quote $quote): bool
    {
        return $user->hasRole('Admin') || 
               ($user->hasRole('Seller') && $user->id === $quote->seller_id);
    }

    /**
     * Determine whether the user can accept the quote.
     */
    public function accept(User $user, Quote $quote): bool
    {
        return $user->hasRole('Buyer') && 
               $user->id === $quote->buyer_id && 
               $quote->status === 'replied';
    }

    /**
     * Determine whether the user can reject the quote.
     */
    public function reject(User $user, Quote $quote): bool
    {
        return $user->hasRole('Buyer') && 
               $user->id === $quote->buyer_id && 
               $quote->status === 'replied';
    }

    /**
     * Determine whether the user can fulfill the quote.
     */
    public function fulfill(User $user, Quote $quote): bool
    {
        return $user->hasRole('Seller') && 
               $user->id === $quote->seller_id && 
               $quote->status === 'accepted';
    }
}