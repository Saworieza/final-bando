<?php

namespace App\Policies;

use App\Models\User;
use App\Models\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true; // Anyone can view news
    }

    public function view(User $user, News $news)
    {
        return true; // Anyone can view individual news
    }

    public function create(User $user)
    {
        // Allow both admin and seller roles
        return $user->hasAnyRole(['Admin', 'Seller']);
    }

    public function update(User $user, News $news)
    {
        // Admin can edit all, seller can only edit their own
        return $user->hasRole('Admin') || 
               ($user->hasRole('Seller') && $news->user_id === $user->id);
    }

    public function delete(User $user, News $news)
    {
        // Same logic as update
        return $this->update($user, $news);
    }
}