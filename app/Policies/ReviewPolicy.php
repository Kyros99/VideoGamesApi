<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;

class ReviewPolicy
{
    public function create(User $user, Game $game)
    {
        return $user->id === $game->user_id;
    }

    public function view(User $user, Game $game)
    {
        return $user->id === $game->user_id;
    }
}
