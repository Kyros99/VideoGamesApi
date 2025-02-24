<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RatingPolicy
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

