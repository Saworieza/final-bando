<?php

namespace App\Policies;

use App\Models\User;
use App\Models\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'seller']);
    }

    public function update(User $user, News $news)
    {
        return $user->hasRole('admin') || ($user->hasRole('seller') && $news->user_id === $user->id);
    }

    public function delete(User $user, News $news)
    {
        return $user->hasRole('admin') || ($user->hasRole('seller') && $news->user_id === $user->id);
    }
}