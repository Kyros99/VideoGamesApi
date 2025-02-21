<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RatingPolicy
{
    /**
     * Determine if the user can create a rating (Only game owner).
     */
    public function create(User $user, Game $game)
    {
        return $user->id === $game->user_id;
    }

    /**
     * Determine if the user can view ratings (Only game owner).
     */
    public function view(User $user, Game $game)
    {
        return $user->id === $game->user_id;
    }

}

